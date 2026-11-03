
@extends('admin.layouts.app')

@section('content')
<div class="p-4 space-y-5">

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Construction Cost Categories</h2>
            <p class="text-sm text-slate-500">Manage construction cost categories by project.</p>
        </div>

        <a href="{{ route('admin.construction-cost-categories.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="flex flex-wrap gap-3 rounded-xl border border-slate-200 bg-white p-4">

        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search category..."
               class="min-w-[180px] rounded-lg border border-slate-200 px-3 py-2 text-sm">

        <select name="project_id" class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>
                    {{ $project->project_name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <option value="">All Status</option>
            <option value="active" @selected(request('status') == 'active')>Active</option>
            <option value="inactive" @selected(request('status') == 'inactive')>Inactive</option>
        </select>

        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white">Filter</button>

        <a href="{{ route('admin.construction-cost-categories.index') }}"
           class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
            Reset
        </a>
    </form>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Category Name</th>
                        <th class="px-4 py-3">Code</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $category->category_name }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $category->category_code ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-slate-600">
                                {{ $category->project->project_name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                @if($category->status === 'active')
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">Inactive</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.construction-cost-categories.show', $category->id) }}"
                                       class="rounded-md border border-slate-200 px-3 py-1.5 text-blue-600">
                                        View
                                    </a>

                                    <a href="{{ route('admin.construction-cost-categories.edit', $category->id) }}"
                                       class="rounded-md border border-slate-200 px-3 py-1.5 text-green-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.construction-cost-categories.destroy', $category->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-md border border-red-200 px-3 py-1.5 text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                No construction cost categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 p-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
