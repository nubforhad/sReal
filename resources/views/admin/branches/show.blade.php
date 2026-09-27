@extends('admin.layouts.app')

@section('title', 'Branch Details')

@section('content')

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('admin.branches.index') }}"
                   class="hover:text-blue-600">
                    Branches
                </a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span>{{ $branch->name }}</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold text-slate-800">
                {{ $branch->name }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Branch details and information.
            </p>
        </div>

        <div class="flex gap-2">     
            <a href="{{ route('admin.branches.edit', $branch) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
            <a href="{{ route('admin.branches.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    {{-- Information --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Details --}}
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-800">
                    Branch Information
                </h2>
            </div>
           <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                {{-- Company --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Company
                    </p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $branch->company->name ?? '-' }}
                    </p>
                </div>
                {{-- Branch --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Branch Name
                    </p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $branch->name }}
                    </p>
                </div>
                {{-- Code --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Branch Code
                    </p>
                    <p class="mt-1">
                        <span class="rounded-md bg-blue-50 px-2.5 py-1 text-sm font-semibold text-blue-700">
                            {{ $branch->code }}
                        </span>
                    </p>
                </div>
                {{-- Phone --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Phone
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $branch->phone ?: '-' }}
                    </p>
                </div>
                {{-- Email --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Email
                    </p>
                    < class="mt-1 text-slate-700">
                        {{ $branch->email ?: '-' }}
                                    <p class="text-xs font-medium uppercase text-slate-400">
                        Status
                    </p>
                    <p class="mt-2">

                        @if($branch->status)

                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        @else
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>

                        @endif
                    </p>
                </div>
                {{-- Address --}}
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Address
                    </p>
                    <p class="mt-1 whitespace-pre-line text-slate-700">
                        {{ $branch->address ?: '-' }}
                    </p>
                </div>
                {{-- Created --}}
                <div>
                    < class="text-xs font-medium uppercase text-slate-400">
                        Created At
                    <p class="mt-1 text-slate-700">
                        {{ $branch->created_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
                {{-- Updated --}}
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Updated At
                        {{ $branch->updated_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>


        {{-- Summary --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-800">
                    Summary
                </h2>
            </div>
            <div class="space-y-4 p-6">
                <div class="rounded-lg bg-blue-50 p-4">
                    <p class="text-sm text-blue-600">
                        Company
                    </p>
                    <p class="mt-1 font-bold text-blue-800">
                        {{ $branch->company->name ?? '-' }}
                    </p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">
                       Branch Code
                    </p>
                    <p class="mt-1 text-xl font-bold text-slate-800">
                        {{ $branch->code }}
                    </p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">
                        Current Status
                    </p>
                    <p class="mt-2">
                        @if($branch->status)
                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>
                        @else
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection