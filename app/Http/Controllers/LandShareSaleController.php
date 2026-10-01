<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Land;
use App\Models\LandShareSale;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LandShareSaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = LandShareSale::with([
            'company',
            'branch',
            'project',
            'land',
            'client',
        ])->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('sale_code', 'like', '%' . $request->search . '%')
                        ->orWhereHas('client', function ($clientQuery) use ($request) {
                            $clientQuery->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('phone', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('land', function ($landQuery) use ($request) {
                            $landQuery->where('land_code', 'like', '%' . $request->search . '%')
                                ->orWhere('land_name', 'like', '%' . $request->search . '%');
                        });
                });
            })->when($request->company_id, function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })->when($request->branch_id, function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })->when($request->project_id, function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            })->when($request->land_id, function ($query) use ($request) {
                $query->where('land_id', $request->land_id);
            })->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })->latest('id')->paginate(15)->withQueryString();
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->orderBy('name')->get();
        $projects = Project::whereIn('status', [
            'planning',
            'ongoing',
        ])->orderBy('project_name')->get();
        $lands = Land::whereIn('status', [
            'available',
            'partially_sold',
        ])->orderBy('land_code')->get();
        return view('admin.land-share-sales.index', compact(
            'sales',
            'companies',
            'branches',
            'projects',
            'lands'
        ));
    }

    public function create()
    {
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        $projects = Project::whereIn('status', [
            'planning',
            'ongoing',
        ])->with(['company', 'branch'])->orderBy('project_name')->get();
        $lands = Land::whereIn('status', [
            'available',
            'partially_sold',
        ])->with(['company', 'branch', 'project'])->orderBy('land_code')->get();
        $clients = Client::where('status', 'active')->with(['company', 'branch', 'project'])->orderBy('name')->get();
        return view('admin.land-share-sales.create', compact(
            'companies',
            'branches',
            'projects',
            'lands',
            'clients'
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
            'land_id' => [
                'required',
                'exists:lands,id',
            ],
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
            'sale_date' => [
                'required',
                'date',
            ],
            'share_size' => [
                'required',
                'numeric',
                'min:0.0001',
            ],

            'share_unit' => [
                'required',
                'string',
                'max:30',
            ],

            'price_per_unit' => [
                'required',
                'numeric',
                'min:0',
            ],

            'land_share_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'confirmed',
                    'cancelled',
                    'completed',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        $branchBelongsToCompany = Branch::where('id', $validated['branch_id'])->where('company_id', $validated['company_id'])->exists();
        if (!$branchBelongsToCompany) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' => 'Selected branch does not belong to the selected company.',
                ]);
        }
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
        | Land belongs to Company + Branch + Project
        |--------------------------------------------------------------------------
        */
        $land = Land::where('id', $validated['land_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$land) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_id' => 'Selected land does not belong to the selected company, branch and project.',
                ]);
        }
 
        $client = Client::where('id', $validated['client_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$client) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' => 'Selected client does not belong to the selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Share Unit Check
        |--------------------------------------------------------------------------
        */
        if ($validated['share_unit'] !== $land->land_unit) {
            return back()
                ->withInput()
                ->withErrors([
                    'share_unit' => 'Share unit must match the land unit.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Available Share Check
        |--------------------------------------------------------------------------
        */
        $soldShare = LandShareSale::where('land_id', $land->id)
            ->where('status', '!=', 'cancelled')
            ->sum('share_size');

        $availableShare = (float) $land->total_land_size - (float) $soldShare;

        if ((float) $validated['share_size'] > $availableShare) {
            return back()
                ->withInput()
                ->withErrors([
                    'share_size' => 'Selected share exceeds available land share. Available: '
                        . number_format($availableShare, 4)
                        . ' '
                        . $land->land_unit,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Price Calculation Check
        |--------------------------------------------------------------------------
        */
        $calculatedPrice =
            (float) $validated['share_size']
            * (float) $validated['price_per_unit'];

        if (abs($calculatedPrice - (float) $validated['land_share_price']) > 0.01) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_price' => 'Land share price must equal share size × price per unit.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate Temporary Sale Code
        |--------------------------------------------------------------------------
        */
        $sale = LandShareSale::create([
            'company_id' => $validated['company_id'],
            'branch_id' => $validated['branch_id'],
            'project_id' => $validated['project_id'],
            'land_id' => $validated['land_id'],
            'client_id' => $validated['client_id'],
            'sale_code' => 'TEMP-' . uniqid(),
            'sale_date' => $validated['sale_date'],
            'share_size' => $validated['share_size'],
            'share_unit' => $validated['share_unit'],
            'price_per_unit' => $validated['price_per_unit'],
            'land_share_price' => $validated['land_share_price'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Final Sale Code
        |--------------------------------------------------------------------------
        */
        $sale->update([
            'sale_code' => 'LSS-'
                . now()->format('Y')
                . '-'
                . str_pad($sale->id, 6, '0', STR_PAD_LEFT),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Land Status
        |--------------------------------------------------------------------------
        */
        $newSoldShare = $soldShare + (float) $validated['share_size'];

        if (
            $land->total_land_size !== null
            && $newSoldShare >= (float) $land->total_land_size
        ) {
            $land->update([
                'status' => 'fully_sold',
            ]);
        } else {
            $land->update([
                'status' => 'partially_sold',
            ]);
        }

        return redirect()
            ->route('admin.land-share-sales.show', $sale)
            ->with('success', 'Land share sale created successfully.');
    }

    public function show(LandShareSale $landShareSale)
    {
        $landShareSale->load([
            'company',
            'branch',
            'project',
            'land',
            'client',
        ]);

        return view(
            'admin.land-share-sales.show',
            compact('landShareSale')
        );
    }

    public function edit(LandShareSale $landShareSale)
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

        $lands = Land::whereIn('status', [
            'available',
            'partially_sold',
            'fully_sold',
        ])
            ->with(['company', 'branch', 'project'])
            ->orderBy('land_code')
            ->get();

        $clients = Client::where('status', 'active')
            ->with(['company', 'branch', 'project'])
            ->orderBy('name')
            ->get();

        return view('admin.land-share-sales.edit', compact(
            'landShareSale',
            'companies',
            'branches',
            'projects',
            'lands',
            'clients'
        ));
    }

    public function update(
        Request $request,
        LandShareSale $landShareSale
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
            'land_id' => [
                'required',
                'exists:lands,id',
            ],
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
            'sale_date' => [
                'required',
                'date',
            ],
            'share_size' => [
                'required',
                'numeric',
                'min:0.0001',
            ],
            'share_unit' => [
                'required',
                'string',
                'max:30',
            ],
            'price_per_unit' => [
                'required',
                'numeric',
                'min:0',
            ],
            'land_share_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'confirmed',
                    'cancelled',
                    'completed',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Branch Validation
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
        | Project Validation
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
        | Land Validation
        |--------------------------------------------------------------------------
        */
        $land = Land::where('id', $validated['land_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$land) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_id' => 'Selected land does not belong to the selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Client Validation
        |--------------------------------------------------------------------------
        */
        $client = Client::where('id', $validated['client_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->where('project_id', $validated['project_id'])
            ->first();

        if (!$client) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' => 'Selected client does not belong to the selected company, branch and project.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Share Unit Validation
        |--------------------------------------------------------------------------
        */
        if ($validated['share_unit'] !== $land->land_unit) {
            return back()
                ->withInput()
                ->withErrors([
                    'share_unit' => 'Share unit must match the land unit.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Available Share
        |--------------------------------------------------------------------------
        */
        $soldShare = LandShareSale::where('land_id', $land->id)
            ->where('id', '!=', $landShareSale->id)
            ->where('status', '!=', 'cancelled')
            ->sum('share_size');

        $availableShare = (float) $land->total_land_size - (float) $soldShare;

        if ((float) $validated['share_size'] > $availableShare) {
            return back()
                ->withInput()
                ->withErrors([
                    'share_size' => 'Selected share exceeds available land share. Available: '
                        . number_format($availableShare, 4)
                        . ' '
                        . $land->land_unit,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Price Validation
        |--------------------------------------------------------------------------
        */
        $calculatedPrice =
            (float) $validated['share_size']
            * (float) $validated['price_per_unit'];

        if (abs($calculatedPrice - (float) $validated['land_share_price']) > 0.01) {
            return back()
                ->withInput()
                ->withErrors([
                    'land_share_price' => 'Land share price must equal share size × price per unit.',
                ]);
        }

        $oldLand = $landShareSale->land;

        $landShareSale->update([
            'company_id' => $validated['company_id'],
            'branch_id' => $validated['branch_id'],
            'project_id' => $validated['project_id'],
            'land_id' => $validated['land_id'],
            'client_id' => $validated['client_id'],
            'sale_date' => $validated['sale_date'],
            'share_size' => $validated['share_size'],
            'share_unit' => $validated['share_unit'],
            'price_per_unit' => $validated['price_per_unit'],
            'land_share_price' => $validated['land_share_price'],
            'status' => $validated['status'],
            'remarks' => $validated['remarks'] ?? null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Recalculate Old Land Status
        |--------------------------------------------------------------------------
        */
        if ($oldLand) {
            $oldSoldShare = LandShareSale::where('land_id', $oldLand->id)
                ->where('status', '!=', 'cancelled')
                ->sum('share_size');

            if (
                $oldLand->total_land_size !== null
                && $oldSoldShare >= (float) $oldLand->total_land_size
            ) {
                $oldLand->update([
                    'status' => 'fully_sold',
                ]);
            } elseif ($oldSoldShare > 0) {
                $oldLand->update([
                    'status' => 'partially_sold',
                ]);
            } else {
                $oldLand->update([
                    'status' => 'available',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Recalculate New Land Status
        |--------------------------------------------------------------------------
        */
        $newSoldShare = LandShareSale::where('land_id', $land->id)
            ->where('status', '!=', 'cancelled')
            ->sum('share_size');

        if (
            $land->total_land_size !== null
            && $newSoldShare >= (float) $land->total_land_size
        ) {
            $land->update([
                'status' => 'fully_sold',
            ]);
        } elseif ($newSoldShare > 0) {
            $land->update([
                'status' => 'partially_sold',
            ]);
        } else {
            $land->update([
                'status' => 'available',
            ]);
        }

        return redirect()
            ->route('admin.land-share-sales.show', $landShareSale)
            ->with('success', 'Land share sale updated successfully.');
    }

    public function destroy(LandShareSale $landShareSale)
    {
        /*
        |--------------------------------------------------------------------------
        | Later: Prevent delete if payments exist
        |--------------------------------------------------------------------------
        */

        $land = $landShareSale->land;

        $landShareSale->delete();

        /*
        |--------------------------------------------------------------------------
        | Recalculate Land Status
        |--------------------------------------------------------------------------
        */
        if ($land) {
            $soldShare = LandShareSale::where('land_id', $land->id)
                ->where('status', '!=', 'cancelled')
                ->sum('share_size');

            if (
                $land->total_land_size !== null
                && $soldShare >= (float) $land->total_land_size
            ) {
                $land->update([
                    'status' => 'fully_sold',
                ]);
            } elseif ($soldShare > 0) {
                $land->update([
                    'status' => 'partially_sold',
                ]);
            } else {
                $land->update([
                    'status' => 'available',
                ]);
            }
        }

        return redirect()
            ->route('admin.land-share-sales.index')
            ->with('success', 'Land share sale deleted successfully.');
    }
}