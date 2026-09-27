@extends('admin.layouts.app')

@section('title', 'Branches')

@section('content')

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Branches
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage company branches.
            </p>
        </div>
        <a href="{{ route('admin.branches.create') }}"  class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
            <i class="bi bi-plus-lg"></i>
            Add Branch
        </a>
    </div>
    {{-- Messages --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif
    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            #
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Company
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Branch
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Code
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Phone
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Email
                        </th>
                        <th class="px-5 py-4 font-semibold text-slate-600">
                            Status
                        </th>
                        <th class="px-5 py-4 text-right font-semibold text-slate-600">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($branches as $branch)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 text-slate-500">
                                {{ $branches->firstItem() + $loop->index }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-700">
                                    {{ $branch->company->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $branch->name }}
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                    {{ $branch->code }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">   {{ $branch->phone ?: '-' }}  </td>

                            <td class="px-5 py-4 text-slate-600">
                                {{ $branch->email ?: '-' }}
                            </td>
                            <td class="px-5 py-4">
                                @if($branch->status)
                                    <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    {{-- View --}}
                                    <a href="{{ route('admin.branches.show', $branch) }}" title="View"  class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.branches.edit', $branch) }}" title="Edit"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this branch?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  title="Delete"  class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-diagram-3 text-4xl text-slate-300"></i>
                                    <h3 class="mt-3 font-semibold text-slate-700"> No branches found  </h3>
                                    <p class="mt-1 text-sm text-slate-500">
                                        Add your first branch to get started.
                                    </p>
                                    <a href="{{ route('admin.branches.create') }}" class="mt-4 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                        Add Branch
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        @if($branches->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $branches->links() }}
            </div>
        @endif
    </div>
</div>

@endsection