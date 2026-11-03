
@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-3xl p-4">

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Category Details</h2>
            <p class="text-sm text-slate-500">Construction cost category information.</p>
        </div>

        <a href="{{ route('admin.construction-cost-categories.index') }}"
           class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
            Back
        </a>
    </div>

    <div class="space-y-4 rounded-xl border border-slate-200 bg-white p-5">

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <p class="text-xs text-slate-500">Category Name</p>
                <p class="mt-1 font-semibold text-slate-800">{{ $category->category_name }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-500">Category Code</p>
                <p class="mt-1 font-semibold text-slate-800">{{ $category->category_code ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-500">Project</p>
                <p class="mt-1 font-semibold text-slate-800">{{ $category->project->project_name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-500">Company</p>
                <p class="mt-1 font-semibold text-slate-800">{{ $category->company->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-500">Branch</p>
                <p class="mt-1 font-semibold text-slate-800">{{ $category->branch->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-xs text-slate-500">Status</p>
                @if($category->status === 'active')
                    <span class="mt-1 inline-block rounded-full bg-green-50 px-3 py-1 text-xs text-green-700">Active</span>
                @else
                    <span class="mt-1 inline-block rounded-full bg-red-50 px-3 py-1 text-xs text-red-700">Inactive</span>
                @endif
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">Description</p>
            <p class="mt-1 whitespace-pre-line text-sm text-slate-700">
                {{ $category->description ?? '-' }}
            </p>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.construction-cost-categories.edit', $category->id) }}"
               class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white">
                Edit Category
            </a>
        </div>

    </div>
</div>
@endsection
