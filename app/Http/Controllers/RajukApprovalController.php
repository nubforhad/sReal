<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\RajukApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RajukApprovalController extends Controller
{
    
    private function scopedProjects()
    {
        $user = auth()->user();

        return Project::query()
            ->where('company_id', $user->company_id)
            ->where('branch_id', $user->branch_id);
    }
 
public function index(Request $request)
{
    $query = RajukApproval::with('project');

    // Search
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('application_no', 'like', "%{$search}%")
                ->orWhere('applicant_name', 'like', "%{$search}%")
                ->orWhere('approval_number', 'like', "%{$search}%")
                ->orWhereHas('project', function ($projectQuery) use ($search) {
                    $projectQuery->where('project_name', 'like', "%{$search}%")
                        ->orWhere('project_code', 'like', "%{$search}%");
                });
        });
    }

    // Status Filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Company Filter
    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    // Branch Filter
    if ($request->filled('branch_id')) {
        $query->where('branch_id', $request->branch_id);
    }

    // Statistics
    $totalApplications = (clone $query)->count();

    $approved = (clone $query)
        ->where('status', 'approved')
        ->count();

    $underReview = (clone $query)
        ->where('status', 'under_review')
        ->count();

    $rejected = (clone $query)
        ->where('status', 'rejected')
        ->count();

    // Pagination
    $rajukApprovals = $query
        ->latest()
        ->paginate(15)
        ->withQueryString();

    return view('admin.rajuk-approvals.index', compact(
        'rajukApprovals',
        'totalApplications',
        'approved',
        'underReview',
        'rejected'
    ));
}


    /*  Create */
   
    public function create()
    {
        $companies = \App\Models\Company::orderBy('name')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();
        $projects = Project::orderBy('project_name')->get();
        return view('admin.rajuk-approvals.create', compact(
            'companies',
            'branches',
            'projects'
        ));
    }


    /*  Store */

    public function store(Request $request)
    {
        $user = auth()->user();
  
$validated = $request->validate([
    'company_id' => [
        'required',
        'integer',
        'exists:companies,id',
    ],

    'branch_id' => [
        'required',
        'integer',
        'exists:branches,id',
    ],

    'project_id' => [
        'required',
        'integer',
        Rule::exists('projects', 'id')
            ->where('company_id', $request->company_id)
            ->where('branch_id', $request->branch_id),
    ],

    'application_no' => ['nullable', 'string', 'max:255'],
    'applicant_name' => ['required', 'string', 'max:255'],
    'applicant_phone' => ['nullable', 'string', 'max:20'],

    'plot_number' => ['nullable', 'string', 'max:255'],
    'road_number' => ['nullable', 'string', 'max:255'],
    'block' => ['nullable', 'string', 'max:255'],
    'mouza' => ['nullable', 'string', 'max:255'],
    'land_area' => ['nullable', 'string', 'max:255'],

    'plan_type' => ['nullable', 'string', 'max:255'],
    'number_of_floors' => ['nullable', 'integer', 'min:1'],
    'number_of_flats' => ['nullable', 'integer', 'min:1'],
    'architect_name' => ['nullable', 'string', 'max:255'],
    'consultant_name' => ['nullable', 'string', 'max:255'],

    'application_date' => ['nullable', 'date'],
    'submission_date' => ['nullable', 'date'],
    'approval_date' => ['nullable', 'date'],

    'approval_number' => ['nullable', 'string', 'max:255'],

    'status' => [
        'required',
        Rule::in([
            'draft',
            'submitted',
            'under_review',
            'approved',
            'rejected',
            'on_hold'
        ]),
    ],

    'remarks' => ['nullable', 'string'],

    'plan_document' => [
        'nullable',
        'file',
        'mimes:pdf,jpg,jpeg,png',
        'max:10240',
    ],

    'approval_document' => [
        'nullable',
        'file',
        'mimes:pdf,jpg,jpeg,png',
        'max:10240',
    ],
]);
 

        if ($request->hasFile('plan_document')) {
            $validated['plan_document'] = $request
                ->file('plan_document')
                ->store('rajuk/plans', 'public');
        }

        if ($request->hasFile('approval_document')) {
            $validated['approval_document'] = $request
                ->file('approval_document')
                ->store('rajuk/approvals', 'public');
        }

        RajukApproval::create($validated);

        return redirect()
            ->route('admin.rajuk-approvals.index')
            ->with('success', 'RAJUK approval created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */
    
    public function show(RajukApproval $rajukApproval)
    {
        $rajukApproval = $this->scopedApprovals()
            ->with([
                'company',
                'branch',
                'project',
            ])
            ->findOrFail($rajukApproval->id);

        return view('admin.rajuk-approvals.show', compact('rajukApproval'));
    } 

        
    private function scopedApprovals()
    {
        $user = auth()->user();

        $query = RajukApproval::query();

        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }

        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(RajukApproval $rajukApproval)
    {
        $rajukApproval = RajukApproval::findOrFail($rajukApproval->id);
        $companies = \App\Models\Company::orderBy('name')->get();
        $branches = \App\Models\Branch::orderBy('name')->get();
        $projects = Project::orderBy('project_name')->get();
        return view('admin.rajuk-approvals.edit', compact(
            'rajukApproval',
            'companies',
            'branches',
            'projects'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
 
public function update(Request $request, RajukApproval $rajukApproval)
{
    $validated = $request->validate([

        'company_id' => [
            'required',
            'integer',
            'exists:companies,id',
        ],

        'branch_id' => [
            'required',
            'integer',
            'exists:branches,id',
        ],

        'project_id' => [
            'required',
            'integer',
            Rule::exists('projects', 'id')
                ->where('company_id', $request->company_id)
                ->where('branch_id', $request->branch_id),
        ],

        'application_no' => [
            'nullable',
            'string',
            'max:255',
        ],

        'applicant_name' => [
            'required',
            'string',
            'max:255',
        ],

        'applicant_phone' => [
            'nullable',
            'string',
            'max:20',
        ],

        'plot_number' => [
            'nullable',
            'string',
            'max:255',
        ],

        'road_number' => [
            'nullable',
            'string',
            'max:255',
        ],

        'block' => [
            'nullable',
            'string',
            'max:255',
        ],

        'mouza' => [
            'nullable',
            'string',
            'max:255',
        ],

        'land_area' => [
            'nullable',
            'string',
            'max:255',
        ],

        'plan_type' => [
            'nullable',
            'string',
            'max:255',
        ],

        'number_of_floors' => [
            'nullable',
            'integer',
            'min:1',
        ],

        'number_of_flats' => [
            'nullable',
            'integer',
            'min:1',
        ],

        'architect_name' => [
            'nullable',
            'string',
            'max:255',
        ],

        'consultant_name' => [
            'nullable',
            'string',
            'max:255',
        ],

        'application_date' => [
            'nullable',
            'date',
        ],

        'submission_date' => [
            'nullable',
            'date',
        ],

        'approval_date' => [
            'nullable',
            'date',
        ],

        'approval_number' => [
            'nullable',
            'string',
            'max:255',
        ],

        'status' => [
            'required',
            Rule::in([
                'draft',
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'on_hold',
            ]),
        ],

        'remarks' => [
            'nullable',
            'string',
        ],

        'plan_document' => [
            'nullable',
            'file',
            'mimes:pdf,jpg,jpeg,png',
            'max:10240',
        ],

        'approval_document' => [
            'nullable',
            'file',
            'mimes:pdf,jpg,jpeg,png',
            'max:10240',
        ],
    ]);


    /*
    |--------------------------------------------------------------------------
    | Upload New Documents
    |--------------------------------------------------------------------------
    */

    if ($request->hasFile('plan_document')) {

        $newPath = $request->file('plan_document')
            ->store('rajuk/plans', 'public');

        if ($rajukApproval->plan_document) {

            Storage::disk('public')
                ->delete($rajukApproval->plan_document);
        }

        $validated['plan_document'] = $newPath;
    }


    if ($request->hasFile('approval_document')) {

        $newPath = $request->file('approval_document')
            ->store('rajuk/approvals', 'public');

        if ($rajukApproval->approval_document) {

            Storage::disk('public')
                ->delete($rajukApproval->approval_document);
        }

        $validated['approval_document'] = $newPath;
    }


    /*
    |--------------------------------------------------------------------------
    | Update RAJUK Approval
    |--------------------------------------------------------------------------
    */

    $rajukApproval->update($validated);


    return redirect()
        ->route('admin.rajuk-approvals.index')
        ->with('success', 'RAJUK approval updated successfully.');
} 

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(RajukApproval $rajukApproval)
    {
        $rajukApproval = $this->scopedApprovals()
            ->findOrFail($rajukApproval->id);

        if ($rajukApproval->plan_document) {
            Storage::disk('public')->delete(
                $rajukApproval->plan_document
            );
        }

        if ($rajukApproval->approval_document) {
            Storage::disk('public')->delete(
                $rajukApproval->approval_document
            );
        }

        $rajukApproval->delete();

        return redirect()
            ->route('admin.rajuk-approvals.index')
            ->with('success', 'RAJUK approval deleted successfully.');
    }
 
    public function print(RajukApproval $rajukApproval)
    {
        $rajukApproval = $this->scopedApprovals()
            ->with([
                'company',
                'branch',
                'project',
            ])
            ->findOrFail($rajukApproval->id);

        return view('admin.rajuk-approvals.print', compact('rajukApproval'));
    } 



}