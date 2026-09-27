@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Users</h1>
            <p class="text-sm text-slate-500">
                Manage system users, company, branch and roles.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
            <i class="bi bi-person-plus"></i>
            Add User
        </a>
    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

                {{-- Search --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700"> Search </label>
                    <input type="text" name="search"  value="{{ request('search') }}" placeholder="Name or email"  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                {{-- Company --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">  Company  </label>
                    <select name="company_id"  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">All Companies</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Branch --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700"> Branch </label>
                    <select name="branch_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">All Branches</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="flex items-end gap-2">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-900">
                        <i class="bi bi-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">  User </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"> Company </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"> Branch </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"> Role </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500"> Status </th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500"> Action </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $user->name }}
                                </div>
                                <div class="text-sm text-slate-500">
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700">
                                {{ $user->company?->name ?? 'All Companies' }}
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700">
                                {{ $user->branch?->name ?? 'All Branches' }}
                            </td>
                            <td class="px-5 py-4">
                                @forelse($user->roles as $role)
                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="text-sm text-slate-400">
                                        No Role
                                    </span>
                                @endforelse
                            </td>
                            <td class="px-5 py-4">
                                @if($user->status)
                                    <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="rounded-lg border border-blue-200 px-3 py-2 text-sm text-blue-600 hover:bg-blue-50"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600 hover:bg-red-50"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="bi bi-people mb-3 text-4xl text-slate-300"></i>
                                    <p class="font-semibold text-slate-600">
                                        No users found
                                    </p>
                                    <p class="mt-1 text-sm text-slate-400">
                                        Add a new user to get started.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')

<script>
    document.querySelectorAll('.delete-user-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            Swal.fire({
                title: 'Delete User?',
                text: 'This user will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endpush