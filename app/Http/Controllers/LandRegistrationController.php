<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\LandRegistration;
use App\Models\LandShareSale;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LandRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = LandRegistration::with([
            'company',
            'branch',
            'project',
            'landShareSale',
            'client',
        ])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where(
                        'registration_code',
                        'like',
                        '%' . $request->search . '%'
                    )
                        ->orWhere(
                            'deed_no',
                            'like',
                            '%' . $request->search . '%'
                        )
                        ->orWhereHas('client', function ($clientQuery) use ($request) {
                            $clientQuery
                                ->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('phone', 'like', '%' . $request->search . '%');
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
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
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

        return view('admin.land-registrations.index', compact(
            'registrations',
            'companies',
            'branches',
            'projects'
        ));
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
            ->orderBy('project_name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Only sales whose land share payment is fully paid
        |--------------------------------------------------------------------------
        */
        $sales = LandShareSale::with([
            'client',
            'land',
            'payments',
        ])
            ->whereIn('status', [
                'confirmed',
                'completed',
            ])
            ->whereDoesntHave('payments', function ($query) {
                // No restriction here.
                // Eligibility is checked below using actual payment total.
            })
            ->latest('id')
            ->get()
            ->filter(function ($sale) {
                return $sale->paid_amount >= $sale->land_share_price;
            });

        return view('admin.land-registrations.create', compact(
            'companies',
            'branches',
            'projects',
            'sales'
        ));
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

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'deed_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'registration_date' => [
                'nullable',
                'date',
            ],

            'sub_registry_office' => [
                'nullable',
                'string',
                'max:255',
            ],

            'district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'upazila' => [
                'nullable',
                'string',
                'max:100',
            ],

            'mouza' => [
                'nullable',
                'string',
                'max:100',
            ],

            'khatian_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'dag_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jl_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'registered_land_size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'land_unit' => [
                'required',
                'string',
                'max:50',
            ],

            'registration_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'other_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],

            'deed_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'registration_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'other_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Company → Branch validation
        |--------------------------------------------------------------------------
        */
        $branchBelongsToCompany = Branch::where('id', $validated['branch_id'])
            ->where('company_id', $validated['company_id'])
            ->exists();

        if (!$branchBelongsToCompany) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' => 'Selected branch does not belong to the selected company.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Company → Branch → Project validation
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
                    'project_id' => 'Selected project does not belong to the selected company and branch.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Load Land Share Sale
        |--------------------------------------------------------------------------
        */
        $sale = LandShareSale::with([
            'payments',
            'client',
        ])->findOrFail($validated['land_share_sale_id']);

        /*
        |--------------------------------------------------------------------------
        | Sale must belong to Company / Branch / Project
        |--------------------------------------------------------------------------
        */
        if (
            $sale->company_id != $validated['company_id'] ||
            $sale->branch_id != $validated['branch_id'] ||
            $sale->project_id != $validated['project_id']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' => 'Selected land share sale does not belong to the selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Client validation
        |--------------------------------------------------------------------------
        */
        if ($sale->client_id != $validated['client_id']) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' => 'Selected client does not belong to the selected land share sale.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sale status validation
        |--------------------------------------------------------------------------
        */
        if (in_array($sale->status, ['cancelled', 'draft'])) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' => 'Registration cannot be created for this sale.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 100% Payment Check
        |--------------------------------------------------------------------------
        */
        $paidAmount = (float) $sale->payments->sum('amount');

        $landSharePrice = (float) $sale->land_share_price;

        if ($paidAmount < $landSharePrice) {
            $dueAmount = $landSharePrice - $paidAmount;

            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Land share payment is not fully paid. Remaining due: ৳ '
                        . number_format($dueAmount, 2),
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Registration
        |--------------------------------------------------------------------------
        */
        $alreadyRegistered = LandRegistration::where(
            'land_share_sale_id',
            $sale->id
        )->exists();

        if ($alreadyRegistered) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'This land share sale already has a registration record.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Total Registration Cost
        |--------------------------------------------------------------------------
        */
        $registrationCost = (float) ($validated['registration_cost'] ?? 0);

        $otherCost = (float) ($validated['other_cost'] ?? 0);

        $totalCost = $registrationCost + $otherCost;

        /*
        |--------------------------------------------------------------------------
        | Upload Documents
        |--------------------------------------------------------------------------
        */
        $deedDocument = null;
        $registrationDocument = null;
        $otherDocument = null;

        if ($request->hasFile('deed_document')) {
            $deedDocument = $request
                ->file('deed_document')
                ->store('land-registrations/deeds', 'public');
        }

        if ($request->hasFile('registration_document')) {
            $registrationDocument = $request
                ->file('registration_document')
                ->store('land-registrations/registrations', 'public');
        }

        if ($request->hasFile('other_document')) {
            $otherDocument = $request
                ->file('other_document')
                ->store('land-registrations/documents', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Temporary Registration Code
        |--------------------------------------------------------------------------
        */
        $registration = LandRegistration::create([
            'company_id' => $validated['company_id'],
            'branch_id' => $validated['branch_id'],
            'project_id' => $validated['project_id'],
            'land_share_sale_id' => $sale->id,
            'client_id' => $validated['client_id'],

            'registration_code' => 'TEMP-' . uniqid(),

            'deed_no' => $validated['deed_no'] ?? null,
            'registration_date' => $validated['registration_date'] ?? null,
            'sub_registry_office' => $validated['sub_registry_office'] ?? null,

            'district' => $validated['district'] ?? null,
            'upazila' => $validated['upazila'] ?? null,
            'mouza' => $validated['mouza'] ?? null,
            'khatian_no' => $validated['khatian_no'] ?? null,
            'dag_no' => $validated['dag_no'] ?? null,
            'jl_no' => $validated['jl_no'] ?? null,

            'registered_land_size' =>
                $validated['registered_land_size'] ?? null,

            'land_unit' => $validated['land_unit'],

            'registration_cost' => $registrationCost,
            'other_cost' => $otherCost,
            'total_cost' => $totalCost,

            'deed_document' => $deedDocument,
            'registration_document' => $registrationDocument,
            'other_document' => $otherDocument,

            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Final Registration Code
        |--------------------------------------------------------------------------
        */
        $registration->update([
            'registration_code' =>
                'REG-' . now()->format('Y') . '-' .
                str_pad($registration->id, 6, '0', STR_PAD_LEFT),
        ]);

        return redirect()
            ->route('admin.land-registrations.show', $registration)
            ->with(
                'success',
                'Land registration created successfully.'
            );
    }

    public function show(LandRegistration $landRegistration)
    {
        $landRegistration->load([
            'company',
            'branch',
            'project',
            'landShareSale.land',
            'landShareSale.payments',
            'client',
        ]);

        return view(
            'admin.land-registrations.show',
            compact('landRegistration')
        );
    }

    public function edit(LandRegistration $landRegistration)
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
            ->orderBy('project_name')
            ->get();

        $sales = LandShareSale::with([
            'client',
            'land',
            'payments',
        ])
            ->whereIn('status', [
                'confirmed',
                'completed',
            ])
            ->latest('id')
            ->get()
            ->filter(function ($sale) use ($landRegistration) {
                return $sale->id == $landRegistration->land_share_sale_id
                    || $sale->paid_amount >= $sale->land_share_price;
            });

        return view('admin.land-registrations.edit', compact(
            'landRegistration',
            'companies',
            'branches',
            'projects',
            'sales'
        ));
    }

    public function update(
        Request $request,
        LandRegistration $landRegistration
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

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'deed_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'registration_date' => [
                'nullable',
                'date',
            ],

            'sub_registry_office' => [
                'nullable',
                'string',
                'max:255',
            ],

            'district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'upazila' => [
                'nullable',
                'string',
                'max:100',
            ],

            'mouza' => [
                'nullable',
                'string',
                'max:100',
            ],

            'khatian_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'dag_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'jl_no' => [
                'nullable',
                'string',
                'max:100',
            ],

            'registered_land_size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'land_unit' => [
                'required',
                'string',
                'max:50',
            ],

            'registration_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'other_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'processing',
                    'completed',
                    'cancelled',
                ]),
            ],

            'deed_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'registration_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'other_document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Company → Branch
        |--------------------------------------------------------------------------
        */
        $branchBelongsToCompany = Branch::where('id', $validated['branch_id'])
            ->where('company_id', $validated['company_id'])
            ->exists();

        if (!$branchBelongsToCompany) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' =>
                        'Selected branch does not belong to the selected company.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Company → Branch → Project
        |--------------------------------------------------------------------------
        */
        $projectExists = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->exists();

        if (!$projectExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'project_id' =>
                        'Selected project does not belong to the selected company and branch.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Sale
        |--------------------------------------------------------------------------
        */
        $sale = LandShareSale::with('payments')
            ->findOrFail($validated['land_share_sale_id']);

        if (
            $sale->company_id != $validated['company_id'] ||
            $sale->branch_id != $validated['branch_id'] ||
            $sale->project_id != $validated['project_id']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Selected sale does not belong to the selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Client
        |--------------------------------------------------------------------------
        */
        if ($sale->client_id != $validated['client_id']) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' =>
                        'Selected client does not belong to the selected land share sale.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | 100% Payment Check
        |--------------------------------------------------------------------------
        */
        $paidAmount = (float) $sale->payments->sum('amount');

        $landSharePrice = (float) $sale->land_share_price;

        if ($paidAmount < $landSharePrice) {
            $dueAmount = $landSharePrice - $paidAmount;

            return back()
                ->withInput()
                ->withErrors([
                    'land_share_sale_id' =>
                        'Land share payment is not fully paid. Remaining due: ৳ '
                        . number_format($dueAmount, 2),
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Total Cost
        |--------------------------------------------------------------------------
        */
        $registrationCost = (float) ($validated['registration_cost'] ?? 0);

        $otherCost = (float) ($validated['other_cost'] ?? 0);

        $totalCost = $registrationCost + $otherCost;

        /*
        |--------------------------------------------------------------------------
        | Existing Files
        |--------------------------------------------------------------------------
        */
        $data = [
            'company_id' => $validated['company_id'],
            'branch_id' => $validated['branch_id'],
            'project_id' => $validated['project_id'],
            'land_share_sale_id' => $sale->id,
            'client_id' => $validated['client_id'],

            'deed_no' => $validated['deed_no'] ?? null,
            'registration_date' =>
                $validated['registration_date'] ?? null,

            'sub_registry_office' =>
                $validated['sub_registry_office'] ?? null,

            'district' => $validated['district'] ?? null,
            'upazila' => $validated['upazila'] ?? null,
            'mouza' => $validated['mouza'] ?? null,
            'khatian_no' => $validated['khatian_no'] ?? null,
            'dag_no' => $validated['dag_no'] ?? null,
            'jl_no' => $validated['jl_no'] ?? null,

            'registered_land_size' =>
                $validated['registered_land_size'] ?? null,

            'land_unit' => $validated['land_unit'],

            'registration_cost' => $registrationCost,
            'other_cost' => $otherCost,
            'total_cost' => $totalCost,

            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ];

        /*
        |--------------------------------------------------------------------------
        | Replace Documents
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('deed_document')) {

            if ($landRegistration->deed_document) {
                Storage::disk('public')
                    ->delete($landRegistration->deed_document);
            }

            $data['deed_document'] = $request
                ->file('deed_document')
                ->store('land-registrations/deeds', 'public');
        }

        if ($request->hasFile('registration_document')) {

            if ($landRegistration->registration_document) {
                Storage::disk('public')
                    ->delete($landRegistration->registration_document);
            }

            $data['registration_document'] = $request
                ->file('registration_document')
                ->store(
                    'land-registrations/registrations',
                    'public'
                );
        }

        if ($request->hasFile('other_document')) {

            if ($landRegistration->other_document) {
                Storage::disk('public')
                    ->delete($landRegistration->other_document);
            }

            $data['other_document'] = $request
                ->file('other_document')
                ->store(
                    'land-registrations/documents',
                    'public'
                );
        }

        $landRegistration->update($data);

        return redirect()
            ->route(
                'admin.land-registrations.show',
                $landRegistration
            )
            ->with(
                'success',
                'Land registration updated successfully.'
            );
    }

    public function destroy(LandRegistration $landRegistration)
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Documents
        |--------------------------------------------------------------------------
        */
        if ($landRegistration->deed_document) {
            Storage::disk('public')
                ->delete($landRegistration->deed_document);
        }

        if ($landRegistration->registration_document) {
            Storage::disk('public')
                ->delete($landRegistration->registration_document);
        }

        if ($landRegistration->other_document) {
            Storage::disk('public')
                ->delete($landRegistration->other_document);
        }

        $landRegistration->delete();

        return redirect()
            ->route('admin.land-registrations.index')
            ->with(
                'success',
                'Land registration deleted successfully.'
            );
    }
}