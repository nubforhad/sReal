<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['company', 'branch'])->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        return view('admin.projects.create', compact(
            'companies',
            'branches'
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

            'project_code' => [
                'required',
                'string',
                'max:50',
            ],
            'project_name' => [
                'required',
                'string',
                'max:255',
            ],

            'project_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
            ],

            'size' => [
                'nullable',
                'string',
                'max:100',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'key_highlights' => [
                'nullable',
                'string',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'expected_completion_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'planning',
                    'ongoing',
                    'completed',
                    'on_hold',
                    'cancelled',
                ]),
            ],

            'share_status' => [
                'required',
                Rule::in([
                    'available',
                    'limited',
                    'sold_out',
                    'closed',
                ]),
            ],

            'working_status' => [
                'required',
                Rule::in([
                    'not_started',
                    'ongoing',
                    'completed',
                    'on_hold',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $branchBelongsToCompany = Branch::where('id', $request->branch_id)->where('company_id', $request->company_id)->exists();
        if (! $branchBelongsToCompany) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' =>
                        'Selected branch does not belong to the selected company.',
                ]);
        }

        $codeExists = Project::where('branch_id', $request->branch_id)
            ->where('project_code', $request->project_code)
            ->exists();

        if ($codeExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'project_code' =>
                        'This project code already exists in the selected branch.',
                ]);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('projects', 'public');
        }
        Project::create($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load([
            'company',
            'branch',
        ]);

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        return view('admin.projects.edit', compact(  'project', 'companies',  'branches'));
    }

    public function update(Request $request, Project $project)
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

            'project_code' => [
                'required',
                'string',
                'max:50',
            ],

            'project_name' => [
                'required',
                'string',
                'max:255',
            ],

            'project_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
            ],

            'size' => [
                'nullable',
                'string',
                'max:100',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'key_highlights' => [
                'nullable',
                'string',
            ],

            'start_date' => [
                'nullable',
                'date',
            ],

            'expected_completion_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'planning',
                    'ongoing',
                    'completed',
                    'on_hold',
                    'cancelled',
                ]),
            ],

            'share_status' => [
                'required',
                Rule::in([
                    'available',
                    'limited',
                    'sold_out',
                    'closed',
                ]),
            ],

            'working_status' => [
                'required',
                Rule::in([
                    'not_started',
                    'ongoing',
                    'completed',
                    'on_hold',
                ]),
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);
        $branchBelongsToCompany = Branch::where('id', $request->branch_id)
            ->where('company_id', $request->company_id)
            ->exists();

        if (! $branchBelongsToCompany) {
            return back()
                ->withInput()
                ->withErrors([
                    'branch_id' =>
                        'Selected branch does not belong to the selected company.',
                ]);
        }

        $codeExists = Project::where('branch_id', $request->branch_id)
            ->where('project_code', $request->project_code)
            ->where('id', '!=', $project->id)
            ->exists();

        if ($codeExists) {
            return back()->withInput()->withErrors([
                    'project_code' =>
                        'This project code already exists in the selected branch.',
                ]);
        }
        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            // Store new image
            $validated['image'] = $request
                ->file('image')
                ->store('projects', 'public');
        }
        $project->update($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }
}