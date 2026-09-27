@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                User Details
            </h1>
            <p class="text-sm text-slate-500">
                View user account and access information.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    {{-- User Card --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        {{-- Profile Header --}}
        <div class="border-b border-slate-200 bg-slate-50 p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-2xl font-bold text-blue-700">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">
                        {{ $user->name }}
                    </h2>
                    <p class="text-sm text-slate-500">
                        {{ $user->email }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Information --}}
        <div class="p-6">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Name
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->name }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Email
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->email }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Company
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->company?->name ?? 'All Companies' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Branch
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->branch?->name ?? 'All Branches' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Role
                    </p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        @forelse($user->roles as $role)
                            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $role->name }}
                            </span>
                        @empty
                            <span class="text-sm text-slate-400">
                                No Role Assigned
                            </span>
                        @endforelse
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400"> Status </p>
                    <div class="mt-2">
                        @if($user->status)
                            <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        @else
                            <span class="inline-flex rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Created At
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->created_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                        Last Updated
                    </p>
                    <p class="mt-1 font-medium text-slate-800">
                        {{ $user->updated_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection