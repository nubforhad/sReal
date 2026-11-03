<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ConstructionCostCategory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConstructionCostCategoryController extends Controller
{
    private function categories()
    {
        $user = auth()->user();

        return ConstructionCostCategory::with(['company', 'branch', 'project'])
            ->when($user->company_id, function ($query) use ($user) {
                $query->where('company_id', $user->company_id);
            })
            ->when($user->branch_id, function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            });
    }

    private function projects()
    {
        $user = auth()->user();

        return Project::query()
            ->when($user->company_id, function ($query) use ($user) {
                $query->where('company_id', $user->company_id);
            })
            ->when($user->branch_id, function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })
            ->orderBy('project_name')
            ->get();
    }

    private function validateData(Request $request, ?ConstructionCostCategory $category = null): array
    {
        $data = $request->validate([
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('construction_cost_categories', 'category_name')
                    ->where('project_id', $request->project_id)
                    ->ignore($category?->id),
            ],
            'category_code' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $user = auth()->user();

        $project = Project::query()
            ->whereKey($data['project_id'])
            ->when($user->company_id, fn ($q) => $q->where('company_id', $user->company_id))
            ->when($user->branch_id, fn ($q) => $q->where('branch_id', $user->branch_id))
            ->firstOrFail();

        $data['company_id'] = $project->company_id;
        $data['branch_id'] = $project->branch_id;

        return $data;
    }

    public function index(Request $request)
    {
        $query = $this->categories();

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('category_name', 'like', "%{$search}%")
                    ->orWhere('category_code', 'like', "%{$search}%");
            });
        }

        $categories = $query->latest()->paginate(15)->withQueryString();

        return view('admin.construction-cost-categories.index', [
            'categories' => $categories,
            'projects' => $this->projects(),
        ]);
    }

    public function create()
    {
        return view('admin.construction-cost-categories.create', [
            'projects' => $this->projects(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        ConstructionCostCategory::create($data);

        return redirect()
            ->route('admin.construction-cost-categories.index')
            ->with('success', 'Construction cost category created successfully.');
    }

    public function show(ConstructionCostCategory $constructionCostCategory)
    {
        $category = $this->categories()
            ->whereKey($constructionCostCategory->id)
            ->firstOrFail();

        return view('admin.construction-cost-categories.show', compact('category'));
    }

    public function edit(ConstructionCostCategory $constructionCostCategory)
    {
        $category = $this->categories()
            ->whereKey($constructionCostCategory->id)
            ->firstOrFail();

        return view('admin.construction-cost-categories.edit', [
            'category' => $category,
            'projects' => $this->projects(),
        ]);
    }

    public function update(Request $request, ConstructionCostCategory $constructionCostCategory)
    {
        $category = $this->categories()
            ->whereKey($constructionCostCategory->id)
            ->firstOrFail();

        $data = $this->validateData($request, $category);

        $category->update($data);

        return redirect()
            ->route('admin.construction-cost-categories.index')
            ->with('success', 'Construction cost category updated successfully.');
    }

    public function destroy(ConstructionCostCategory $constructionCostCategory)
    {
        $category = $this->categories()
            ->whereKey($constructionCostCategory->id)
            ->firstOrFail();

        $category->delete();

        return redirect()
            ->route('admin.construction-cost-categories.index')
            ->with('success', 'Construction cost category deleted successfully.');
    }
}