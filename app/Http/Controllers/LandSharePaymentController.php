<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\LandSharePayment;
use App\Models\LandShareSale;
use App\Models\Project;
use Illuminate\Http\Request;

class LandSharePaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = LandSharePayment::with([
            'company',
            'branch',
            'project',
            'landShareSale',
            'client',
        ])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {

                    $q->where(
                        'receipt_no',
                        'like',
                        '%' . $request->search . '%'
                    )
                    ->orWhere(
                        'transaction_no',
                        'like',
                        '%' . $request->search . '%'
                    )
                    ->orWhereHas('client', function ($clientQuery) use ($request) {
                        $clientQuery
                            ->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere(
                                'phone',
                                'like',
                                '%' . $request->search . '%'
                            );
                    })
                    ->orWhereHas('landShareSale', function ($saleQuery) use ($request) {
                        $saleQuery->where(
                            'sale_code',
                            'like',
                            '%' . $request->search . '%'
                        );
                    });
                });
            })
            ->when($request->company_id, function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })
            ->when($request->branch_id, function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })
            ->when($request->project_id, function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            })
            ->when($request->payment_method, function ($query) use ($request) {
                $query->where(
                    'payment_method',
                    $request->payment_method
                );
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->orderBy('name')
            ->get();

        $projects = Project::whereIn('status', [
            'planning',
            'ongoing',
        ])
            ->orderBy('project_name')
            ->get();

        return view(
            'admin.land-share-payments.index',
            compact(
                'payments',
                'companies',
                'branches',
                'projects'
            )
        );
    }

    public function create()
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::whereIn('status', [
            'planning',
            'ongoing',
        ])
            ->with(['company', 'branch'])
            ->orderBy('project_name')
            ->get();

        $sales = LandShareSale::with([
            'company',
            'branch',
            'project',
            'land',
            'client',
        ])
            ->whereIn('status', [
                'confirmed',
                'completed',
            ])
            ->latest('id')
            ->get();

        return view(
            'admin.land-share-payments.create',
            compact(
                'companies',
                'branches',
                'projects',
                'sales'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'land_share_sale_id' => [
                'required',
                'exists:land_share_sales,id',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,cheque,mobile_banking,online,other',
            ],

            'transaction_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'cheque_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Branch belongs to Company
        |--------------------------------------------------------------------------
        */
        $branch = Branch::where('id', $validated['branch_id'])
            ->where('company_id', $validated['company_id'])
            ->first();

        if (!$branch) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' =>
                        'Selected branch does not belong to selected company.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Project belongs to Company + Branch
        |--------------------------------------------------------------------------
        */
        $project = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->first();

        if (!$project) {
            return back()
                ->withInput()
                ->withErrors([
                    'project_id' =>
                        'Selected project does not belong to selected company and branch.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sale belongs to Company + Branch + Project
        |--------------------------------------------------------------------------
        */
        $sale = LandShareSale::where('id', $validated['land_share_sale_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$sale) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Selected sale does not belong to selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cancelled Sale Cannot Receive Payment
        |--------------------------------------------------------------------------
        */
        if ($sale->status === 'cancelled') {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Payment cannot be added to a cancelled sale.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Current Paid Amount
        |--------------------------------------------------------------------------
        */
        $paidAmount = (float) $sale->payments()->sum('amount');

        $dueAmount = max(
            0,
            (float) $sale->land_share_price - $paidAmount
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent Over Payment
        |--------------------------------------------------------------------------
        */
        if ((float) $validated['amount'] > $dueAmount) {
            return back()
                ->withInput()
                ->withErrors([
                    'amount' =>
                        'Payment amount cannot exceed current due amount. Due: ৳ '
                        . number_format($dueAmount, 2),
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Client
        |--------------------------------------------------------------------------
        */
        $client = $sale->client;

        /*
        |--------------------------------------------------------------------------
        | Temporary Receipt Number
        |--------------------------------------------------------------------------
        */
        $payment = LandSharePayment::create([
            'company_id' => $sale->company_id,
            'branch_id' => $sale->branch_id,
            'project_id' => $sale->project_id,
            'land_share_sale_id' => $sale->id,
            'client_id' => $client->id,
            'receipt_no' => 'TEMP-' . uniqid(),
            'payment_date' => $validated['payment_date'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'transaction_no' => $validated['transaction_no'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'cheque_no' => $validated['cheque_no'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Final Receipt Number
        |--------------------------------------------------------------------------
        */
        $payment->update([
            'receipt_no' =>
                'LSP-'
                . now()->format('Y')
                . '-'
                . str_pad($payment->id, 6, '0', STR_PAD_LEFT),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'admin.land-share-payments.show',
                $payment
            )
            ->with(
                'success',
                'Land share payment recorded successfully.'
            );
    }

    public function show(LandSharePayment $landSharePayment)
    {
        $landSharePayment->load([
            'company',
            'branch',
            'project',
            'landShareSale.land',
            'client',
        ]);

        return view(
            'admin.land-share-payments.show',
            compact('landSharePayment')
        );
    }

    public function edit(LandSharePayment $landSharePayment)
    {
        $landSharePayment->load([
            'landShareSale',
        ]);

        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::whereIn('status', [
            'planning',
            'ongoing',
        ])
            ->with(['company', 'branch'])
            ->orderBy('project_name')
            ->get();

        $sales = LandShareSale::with([
            'company',
            'branch',
            'project',
            'land',
            'client',
        ])
            ->whereIn('status', [
                'confirmed',
                'completed',
            ])
            ->latest('id')
            ->get();

        return view(
            'admin.land-share-payments.edit',
            compact(
                'landSharePayment',
                'companies',
                'branches',
                'projects',
                'sales'
            )
        );
    }

    public function update(
        Request $request,
        LandSharePayment $landSharePayment
    ) {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'land_share_sale_id' => [
                'required',
                'exists:land_share_sales,id',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank,cheque,mobile_banking,online,other',
            ],

            'transaction_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'cheque_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sale Validation
        |--------------------------------------------------------------------------
        */
        $sale = LandShareSale::where('id', $validated['land_share_sale_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$sale) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Selected sale does not belong to selected company, branch and project.',
                ]);
        }

        if ($sale->status === 'cancelled') {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Payment cannot be added to a cancelled sale.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Existing Payments Except Current
        |--------------------------------------------------------------------------
        */
        $paidAmount = (float) LandSharePayment::where(
            'land_share_sale_id',
            $sale->id
        )
            ->where('id', '!=', $landSharePayment->id)
            ->sum('amount');

        $dueAmount = max(
            0,
            (float) $sale->land_share_price - $paidAmount
        );

        if ((float) $validated['amount'] > $dueAmount) {
            return back()
                ->withInput()
                ->withErrors([
                    'amount' =>
                        'Payment amount cannot exceed current due amount. Due: ৳ '
                        . number_format($dueAmount, 2),
                ]);
        }

        $landSharePayment->update([
            'company_id' => $sale->company_id,
            'branch_id' => $sale->branch_id,
            'project_id' => $sale->project_id,
            'land_share_sale_id' => $sale->id,
            'client_id' => $sale->client_id,
            'payment_date' => $validated['payment_date'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'transaction_no' => $validated['transaction_no'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'cheque_no' => $validated['cheque_no'] ?? null,
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return redirect()
            ->route(
                'admin.land-share-payments.show',
                $landSharePayment
            )
            ->with(
                'success',
                'Land share payment updated successfully.'
            );
    }

    public function destroy(LandSharePayment $landSharePayment)
    {
        $landSharePayment->delete();

        return redirect()
            ->route('admin.land-share-payments.index')
            ->with(
                'success',
                'Land share payment deleted successfully.'
            );
    }
}