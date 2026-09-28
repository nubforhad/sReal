<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Land;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LandController extends Controller
{
    /**
     * Display a listing of lands.
     */
    public function index(Request $request)
    {
        $lands = Land::with([
                'company',
                'branch',
                'project',
            ])
            ->when($request->search, function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('land_code', 'like', "%{$search}%")
                        ->orWhere('land_name', 'like', "%{$search}%")
                        ->orWhere('mouza', 'like', "%{$search}%")
                        ->orWhere('khatian_no', 'like', "%{$search}%")
                        ->orWhere('dag_no', 'like', "%{$search}%")
                        ->orWhere('owner_name', 'like', "%{$search}%");
                });

            })->when($request->company_id, function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })->when($request->branch_id, function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })->when($request->project_id, function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            })->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })->latest()->paginate(15)->withQueryString();
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        $projects = Project::with([
                'company',
                'branch',
            ])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ]) ->orderBy('project_name')->get();
        return view('admin.lands.index', compact('lands', 'companies', 'branches', 'projects'));
    }


    /**
     * Show the form for creating a new land.
     */
    public function create()
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::with([
                'company',
                'branch',
            ])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ])
            ->orderBy('project_name')
            ->get();

        return view('admin.lands.create', compact(
            'companies',
            'branches',
            'projects'
        ));
    }


    /**
     * Store a newly created land.
     */
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

            'land_code' => [
                'required',
                'string',
                'max:100',
            ],

            'land_name' => [
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
                'max:150',
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

            'total_land_size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'land_unit' => [
                'required',
                'string',
                'max:30',
            ],

            'owner_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'owner_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'owner_nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchase_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'available',
                    'partially_sold',
                    'fully_sold',
                    'registered',
                    'closed',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Branch → Company Validation
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
        | Project → Company + Branch Validation
        |--------------------------------------------------------------------------
        */

        $projectBelongsToBranch = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->exists();

        if (!$projectBelongsToBranch) {

            return back()
                ->withInput()
                ->withErrors([
                    'project_id' =>
                        'Selected project does not belong to the selected company and branch.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Land Code Unique Inside Branch
        |--------------------------------------------------------------------------
        */

        $landExists = Land::where('branch_id', $validated['branch_id'])
            ->where('land_code', $validated['land_code'])
            ->exists();

        if ($landExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'land_code' =>
                        'This land code already exists in the selected branch.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Create Land
        |--------------------------------------------------------------------------
        */

        Land::create($validated);


        return redirect()
            ->route('admin.lands.index')
            ->with('success', 'Land created successfully.');
    }


    /**
     * Display the specified land.
     */
    public function show(Land $land)
    {
        $land->load([
            'company',
            'branch',
            'project',
        ]);

        return view('admin.lands.show', compact('land'));
    }


    /**
     * Show the form for editing the specified land.
     */
    public function edit(Land $land)
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::with([
                'company',
                'branch',
            ])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ])
            ->orderBy('project_name')
            ->get();

        return view('admin.lands.edit', compact(
            'land',
            'companies',
            'branches',
            'projects'
        ));
    }


    /**
     * Update the specified land.
     */
    public function update(Request $request, Land $land)
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

            'land_code' => [
                'required',
                'string',
                'max:100',
            ],

            'land_name' => [
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
                'max:150',
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

            'total_land_size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'land_unit' => [
                'required',
                'string',
                'max:30',
            ],

            'owner_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'owner_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'owner_nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'purchase_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchase_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'available',
                    'partially_sold',
                    'fully_sold',
                    'registered',
                    'closed',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Branch → Company Validation
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
        | Project → Company + Branch Validation
        |--------------------------------------------------------------------------
        */

        $projectBelongsToBranch = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->exists();

        if (!$projectBelongsToBranch) {

            return back()
                ->withInput()
                ->withErrors([
                    'project_id' =>
                        'Selected project does not belong to the selected company and branch.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Unique Land Code Inside Branch
        |--------------------------------------------------------------------------
        */

        $landExists = Land::where('branch_id', $validated['branch_id'])
            ->where('land_code', $validated['land_code'])
            ->where('id', '!=', $land->id)
            ->exists();

        if ($landExists) {

            return back()
                ->withInput()
                ->withErrors([
                    'land_code' =>
                        'This land code already exists in the selected branch.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $land->update($validated);


        return redirect()
            ->route('admin.lands.index')
            ->with('success', 'Land updated successfully.');
    }


    /**
     * Remove the specified land.
     */
    public function destroy(Land $land)
    {
        /*
        |--------------------------------------------------------------------------
        | Safety Check
        |--------------------------------------------------------------------------
        |
        | Later, when Land Share Sale / Payment records are connected,
        | deletion should be blocked if financial records exist.
        |
        */

        $land->delete();

        return redirect()
            ->route('admin.lands.index')
            ->with('success', 'Land deleted successfully.');
    }
}