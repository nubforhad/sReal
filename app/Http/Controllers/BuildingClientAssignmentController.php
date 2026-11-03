<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Client;
use App\Models\BuildingClientAssignment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingClientAssignmentController extends Controller
{
    private function scopedAssignments()
    {
        $user = auth()->user();

        $query = BuildingClientAssignment::with([
            'building',
            'client',
            'project',
        ]);

        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }

        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    private function scopedBuildings()
    {
        $user = auth()->user();

        $query = Building::query()
            ->with('project');

        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }

        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    private function scopedClients()
    {
        $user = auth()->user();

        $query = Client::query();

        if (!is_null($user->company_id)) {
            $query->where('company_id', $user->company_id);
        }

        if (!is_null($user->branch_id)) {
            $query->where('branch_id', $user->branch_id);
        }

        return $query;
    }

    private function validateAssignment(Request $request): array
    {
        $validated = $request->validate([
            'building_id' => [
                'required',
                'integer',
                Rule::exists('buildings', 'id'),
            ],

            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id'),
            ],

            'assigned_at' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],

            'remarks' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $building = $this->scopedBuildings()
            ->findOrFail($validated['building_id']);

        $client = $this->scopedClients()
            ->findOrFail($validated['client_id']);

        if (
            $building->company_id != $client->company_id ||
            $building->branch_id != $client->branch_id ||
            $building->project_id != $client->project_id
        ) {
            abort(422, 'Building and Client must belong to the same Company, Branch and Project.');
        }

        $validated['company_id'] = $building->company_id;
        $validated['branch_id'] = $building->branch_id;
        $validated['project_id'] = $building->project_id;

        return $validated;
    }

    public function index(Request $request)
    {
        $query = $this->scopedAssignments();

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $assignments = $query->latest()->paginate(15)->withQueryString();

        $buildings = $this->scopedBuildings()
            ->orderBy('building_name')
            ->get();

        $clients = $this->scopedClients()
            ->orderBy('name')
            ->get();

        return view('admin.building-client-assignments.index', compact(
            'assignments',
            'buildings',
            'clients'
        ));
    }

    public function create()
    {
        $buildings = $this->scopedBuildings()
            ->orderBy('building_name')
            ->get();

        $clients = $this->scopedClients()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.building-client-assignments.create', compact(
            'buildings',
            'clients'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAssignment($request);

        $exists = BuildingClientAssignment::where(
            'building_id',
            $validated['building_id']
        )->where(
            'client_id',
            $validated['client_id']
        )->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' => 'This client is already assigned to this building.',
                ]);
        }

        BuildingClientAssignment::create($validated);

        return redirect()
            ->route('admin.building-client-assignments.index')
            ->with('success', 'Client assigned to building successfully.');
    }

    public function edit(BuildingClientAssignment $buildingClientAssignment)
    {
        $assignment = $this->scopedAssignments()
            ->findOrFail($buildingClientAssignment->id);

        $buildings = $this->scopedBuildings()
            ->orderBy('building_name')
            ->get();

        $clients = $this->scopedClients()
            ->orderBy('name')
            ->get();

        return view('admin.building-client-assignments.edit', compact(
            'assignment',
            'buildings',
            'clients'
        ));
    }

    public function update(
        Request $request,
        BuildingClientAssignment $buildingClientAssignment
    ) {
        $assignment = $this->scopedAssignments()
            ->findOrFail($buildingClientAssignment->id);

        $validated = $this->validateAssignment($request);

        $exists = BuildingClientAssignment::where(
            'building_id',
            $validated['building_id']
        )->where(
            'client_id',
            $validated['client_id']
        )->where(
            'id',
            '!=',
            $assignment->id
        )->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'client_id' => 'This client is already assigned to this building.',
                ]);
        }

        $assignment->update($validated);

        return redirect()
            ->route('admin.building-client-assignments.index')
            ->with('success', 'Building client assignment updated successfully.');
    }

    public function destroy(BuildingClientAssignment $buildingClientAssignment)
    {
        $assignment = $this->scopedAssignments()
            ->findOrFail($buildingClientAssignment->id);

        $assignment->delete();

        return redirect()
            ->route('admin.building-client-assignments.index')
            ->with('success', 'Building client assignment deleted successfully.');
    }
}