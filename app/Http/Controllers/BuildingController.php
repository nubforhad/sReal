<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Project;
use App\Models\RajukApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | User Scope
    |--------------------------------------------------------------------------
    */

    private function scopedBuildings()
    {
        $user = auth()->user();
        $query = Building::query();
        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }
        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }
        return $query;
    }

    private function scopedProjects()
    {
        $user = auth()->user();

        $query = Project::query();

        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }
        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    private function scopedCompanies()
    {
        $query = Company::query();

        if (auth()->user()->company_id) {
            $query->where('id', auth()->user()->company_id);
        }

        return $query;
    }

    private function scopedBranches()
    {
        $query = Branch::query();

        if (auth()->user()->branch_id) {
            $query->where('id', auth()->user()->branch_id);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    private function validateBuilding(Request $request): array
    {
        $user = auth()->user();

        $validated = $request->validate([
            'company_id' => [
                'required',
                'integer',
                Rule::exists('companies', 'id'),
                $user->company_id
                    ? Rule::in([$user->company_id])
                    : 'nullable',
            ],

            'branch_id' => [
                'required',
                'integer',
                Rule::exists('branches', 'id'),
                $user->branch_id
                    ? Rule::in([$user->branch_id])
                    : 'nullable',
            ],

            'project_id' => [
                'required',
                'integer',
                Rule::exists('projects', 'id')
                    ->where('company_id', $request->company_id)
                    ->where('branch_id', $request->branch_id),
            ],

            'rajuk_approval_id' => [
                'nullable',
                'integer',
                Rule::exists('rajuk_approvals', 'id')
                    ->where('company_id', $request->company_id)
                    ->where('branch_id', $request->branch_id)
                    ->where('project_id', $request->project_id),
            ],

            'building_code' => ['nullable', 'string', 'max:100'],
            'building_name' => ['required', 'string', 'max:255'],
            'building_type' => ['nullable', 'string', 'max:255'],

            'number_of_floors' => ['nullable', 'integer', 'min:1'],
            'number_of_basements' => ['nullable', 'integer', 'min:0'],
            'total_flats' => ['nullable', 'integer', 'min:0'],

            'construction_start_date' => ['nullable', 'date'],
            'expected_completion_date' => [
                'nullable',
                'date',
                'after_or_equal:construction_start_date',
            ],
            'actual_completion_date' => [
                'nullable',
                'date',
                'after_or_equal:construction_start_date',
            ],

            'contractor_name' => ['nullable', 'string', 'max:255'],
            'contractor_phone' => ['nullable', 'string', 'max:20'],
            'architect_name' => ['nullable', 'string', 'max:255'],
            'engineer_name' => ['nullable', 'string', 'max:255'],

            'status' => [
                'required',
                Rule::in([
                    'planning',
                    'preparation',
                    'ongoing',
                    'paused',
                    'completed',
                    'on_hold',
                ]),
            ],

            'description' => ['nullable', 'string'],

            'building_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        return $validated;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = $this->scopedBuildings()
            ->with(['company', 'branch', 'project', 'rajukApproval']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('building_name', 'like', "%{$search}%")
                    ->orWhere('building_code', 'like', "%{$search}%")
                    ->orWhere('contractor_name', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($projectQuery) use ($search) {
                        $projectQuery->where(
                            'project_name',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $buildings = $query->latest()
            ->paginate(15)
            ->withQueryString();

        // Filter dropdown data
        $companies = $this->scopedCompanies()
            ->orderBy('name')
            ->get();

        $branches = $this->scopedBranches()
            ->orderBy('name')
            ->get();

        $projects = $this->scopedProjects()
            ->orderBy('project_name')
            ->get();

        return view('admin.buildings.index', compact(
            'buildings',
            'companies',
            'branches',
            'projects'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $companies = $this->scopedCompanies()->orderBy('name')->get();
        $branches = $this->scopedBranches()->orderBy('name')->get();
        $projects = $this->scopedProjects()->orderBy('project_name')->get();

        $rajukApprovals = RajukApproval::query()
            ->when(auth()->user()->company_id, function ($query, $companyId) {
                $query->where('company_id', $companyId);
            })
            ->when(auth()->user()->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->where('status', 'approved')
            ->get();

        return view('admin.buildings.create', compact(
            'companies',
            'branches',
            'projects',
            'rajukApprovals'
        ));
    }

    /* Store  */

    public function store(Request $request)
    {
        $validated = $this->validateBuilding($request);
        $validated['company_id'] = auth()->user()->company_id
            ?? $request->company_id;
        $validated['branch_id'] = auth()->user()->branch_id
            ?? $request->branch_id;
        if ($request->hasFile('building_image')) {
            $validated['building_image'] = $request
                ->file('building_image')
                ->store('buildings/images', 'public');
        }

        if ($request->hasFile('document')) {
            $validated['document'] = $request
                ->file('document')
                ->store('buildings/documents', 'public');
        }

        Building::create($validated);

        return redirect()->route('admin.buildings.index')->with('success', 'Building created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(Building $building)
    {
        $building = $this->scopedBuildings()->with([
                'company',
                'branch',
                'project',
                'rajukApproval',
            ])->findOrFail($building->id);

        return view('admin.buildings.show', compact('building'));
    }

    /*   Edit  */

    public function edit(Building $building)
    {
        $building = $this->scopedBuildings()->findOrFail($building->id);
        $companies = $this->scopedCompanies()->orderBy('name')->get();
        $branches = $this->scopedBranches()->orderBy('name')->get();
        $projects = $this->scopedProjects()->orderBy('project_name')->get();

        $rajukApprovals = RajukApproval::query()
            ->where('company_id', $building->company_id)
            ->where('branch_id', $building->branch_id)
            ->where('project_id', $building->project_id)
            ->get();

        return view('admin.buildings.edit', compact(
            'building',
            'companies',
            'branches',
            'projects',
            'rajukApprovals'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Building $building)
{
    // Logged-in user's company and branch scope check
    $building = $this->scopedBuildings()
        ->findOrFail($building->id);

    // Validate request
    $validated = $this->validateBuilding($request);

    // Company and Branch
    $validated['company_id'] = auth()->user()->company_id
        ?? $request->company_id;

    $validated['branch_id'] = auth()->user()->branch_id
        ?? $request->branch_id;

    // Keep old file paths
    $oldImage = $building->building_image;
    $oldDocument = $building->document;

    // Upload new image
    if ($request->hasFile('building_image')) {
        $validated['building_image'] = $request
            ->file('building_image')
            ->store('buildings/images', 'public');
    } else {
        unset($validated['building_image']);
    }

    // Upload new document
    if ($request->hasFile('document')) {
        $validated['document'] = $request
            ->file('document')
            ->store('buildings/documents', 'public');
    } else {
        unset($validated['document']);
    }

    // Update database
    $building->update($validated);

    // Delete old image after successful update
    if (
        $request->hasFile('building_image') &&
        $oldImage
    ) {
        Storage::disk('public')->delete($oldImage);
    }

    // Delete old document after successful update
    if (
        $request->hasFile('document') &&
        $oldDocument
    ) {
        Storage::disk('public')->delete($oldDocument);
    }

    return redirect()
        ->route('admin.buildings.index')
        ->with('success', 'Building updated successfully.');
}

    /*  Destroy */

    public function destroy(Building $building)
    {
        $building = $this->scopedBuildings()
            ->findOrFail($building->id);

        if ($building->building_image) {
            Storage::disk('public')->delete(
                $building->building_image
            );
        }

        if ($building->document) {
            Storage::disk('public')->delete(
                $building->document
            );
        }

        $building->delete();

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Building deleted successfully.');
    }

    public function print(Building $building)
    {
        $building = $this->scopedBuildings()
            ->with([
                'company',
                'branch',
                'project',
                'rajukApproval',
            ])->findOrFail($building->id);
        return view('admin.buildings.print', compact('building'));
    }


}