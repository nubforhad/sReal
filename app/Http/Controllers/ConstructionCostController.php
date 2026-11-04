<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\BuildingClientAssignment;
use App\Models\ConstructionCost;
use App\Models\ConstructionCostCategory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ConstructionCostController extends Controller
{
    private function scope($query)
    {
        $user = auth()->user();

        return $query
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )
            ->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            );
    }

    private function projects()
    {
        $user = auth()->user();

        return Project::query()
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )
            ->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            )->orderBy('project_name')
            ->get();
    }

    private function assignments()
    {
        return $this->scope(
            BuildingClientAssignment::with(['building', 'client', 'project'])
                ->where('status', 'active')
        )->get();
    }

    private function categories()
    {
        return $this->scope( ConstructionCostCategory::where('status', 'active'))->get();
    }

    private function costs()
    {
        return $this->scope(
            ConstructionCost::with([
                'project',
                'building',
                'client',
                'category',
                'creator',
            ])
        );
    }

    /**
     * Validate and resolve the selected assignment and category.
     */
    private function validateCost(Request $request): array
    {
        $data = $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'building_id' => ['required', 'integer', 'exists:buildings,id'],
            'building_client_assignment_id' => [
                'required',
                'integer',
                'exists:building_client_assignments,id',
            ],
            'construction_cost_category_id' => [
                'required',
                'integer',
                'exists:construction_cost_categories,id',
            ],
            'cost_date' => ['required', 'date'],
            'payment_date' => ['nullable', 'date', 'after_or_equal:cost_date'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999999.99'],
            'description' => ['nullable', 'string', 'max:5000'],
            'document' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120'],
        ]);

        $user = auth()->user();

        $project = Project::query()
            ->whereKey($data['project_id'])
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            )->firstOrFail();

        $building = Building::query()
            ->whereKey($data['building_id'])
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->firstOrFail();

        $assignment = BuildingClientAssignment::query()
            ->whereKey($data['building_client_assignment_id'])
            ->where('building_id', $building->id)
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->where('status', 'active')
            ->firstOrFail();

        $category = ConstructionCostCategory::query()
            ->whereKey($data['construction_cost_category_id'])
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->where('status', 'active')
            ->firstOrFail();

        $data['company_id'] = $project->company_id;
        $data['branch_id'] = $project->branch_id;
        $data['project_id'] = $project->id;
        $data['building_id'] = $building->id;
        $data['client_id'] = $assignment->client_id;
        $data['building_client_assignment_id'] = $assignment->id;
        $data['created_by'] = $user->id;

        return $data;
    }

    public function index(Request $request)
    {
        $query = $this->costs();

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('cost_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('cost_date', '<=', $request->to_date);
        }

        $costs = $query->latest('cost_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.construction-costs.index', [
            'costs' => $costs,
            'projects' => $this->projects(),
        ]);
    }

    public function create()
    {
        return view('admin.construction-costs.create', [
            'projects' => $this->projects(),
            'assignments' => $this->assignments(),
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateCost($request);

        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')
                ->store('construction-costs', 'public');
        }
        ConstructionCost::create($data);
        return redirect()->route('admin.construction-costs.index')->with('success', 'Construction cost added successfully.');
    }

    public function show(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()->whereKey($constructionCost->id)->firstOrFail();
        return view('admin.construction-costs.show', compact('cost'));
    }

    public function edit(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()->whereKey($constructionCost->id)->firstOrFail();

        return view('admin.construction-costs.edit', [
            'cost' => $cost,
            'projects' => $this->projects(),
            'assignments' => $this->assignments(),
            'categories' => $this->categories(),
        ]);
    }

    public function update(Request $request, ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();
        $data = $this->validateCost($request);
        if ($request->hasFile('document')) {
            if ($cost->document) {
                Storage::disk('public')->delete($cost->document);
            }
            $data['document'] = $request->file('document')
                ->store('construction-costs', 'public');
        } else {
            unset($data['document']);
        }
        $cost->update($data);
        return redirect()->route('admin.construction-costs.index')->with('success', 'Construction cost updated successfully.');
    }

    public function destroy(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();
        if ($cost->document) {
            Storage::disk('public')->delete($cost->document);
        }
        $cost->delete();
        return redirect()->route('admin.construction-costs.index')->with('success', 'Construction cost deleted successfully.');
    }
}