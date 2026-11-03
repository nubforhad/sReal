
@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-3xl p-4">

    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Add Construction Cost Category</h2>
        <p class="text-sm text-slate-500">Create a new category for construction expenses.</p>
    </div>

    <form action="{{ route('admin.construction-cost-categories.store') }}" method="POST"
          class="space-y-5 rounded-xl border border-slate-200 bg-white p-5">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Project *</label>
            <select name="project_id" required
                    class="w-full rounded-lg border border-slate-200 px-3 py-2">
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" @selected(old('project_id') == $project->id)>
                        {{ $project->project_name }}
                    </option>
                @endforeach
            </select>
            @error('project_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Category Name *</label>
            <input type="text" name="category_name" value="{{ old('category_name') }}"
                   required placeholder="e.g. Rod, Cement, Sand"
                   class="w-full rounded-lg border border-slate-200 px-3 py-2">
            @error('category_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Category Code</label>
            <input type="text" name="category_code" value="{{ old('category_code') }}"
                   placeholder="e.g. CON-001"
                   class="w-full rounded-lg border border-slate-200 px-3 py-2">
            @error('category_code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border border-slate-200 px-3 py-2">{{ old('description') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Status *</label>
            <select name="status" required class="w-full rounded-lg border border-slate-200 px-3 py-2">
                <option value="active" @selected(old('status', 'active') == 'active')>Active</option>
                <option value="inactive" @selected(old('status') == 'inactive')>Inactive</option>
            </select>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
            <a href="{{ route('admin.construction-cost-categories.index') }}"
               class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Save Category
            </button>
        </div>
    </form>
</div>
@endsection
