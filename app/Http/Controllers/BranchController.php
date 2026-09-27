<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('company')
            ->latest()
            ->paginate(15);

        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.branches.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('branches', 'code')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'company_id',
                            $request->company_id
                        );
                    }),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        Branch::create($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        $branch->load('company');

        return view('admin.branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        return view('admin.branches.edit', compact(
            'branch',
            'companies'
        ));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'code' => [
                'required',
                'string',
                'max:50',

                Rule::unique('branches', 'code')
                    ->where(function ($query) use ($request) {
                        return $query->where(
                            'company_id',
                            $request->company_id
                        );
                    })
                    ->ignore($branch->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        $branch->update($validated);

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()
            ->route('admin.branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}