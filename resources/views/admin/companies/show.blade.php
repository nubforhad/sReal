@extends('admin.layouts.app')

@section('title', 'Company Details')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('admin.companies.index') }}"
                   class="hover:text-blue-600">
                    Companies
                </a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span>{{ $company->name }}</span>
            </div>
            <h1 class="mt-2 text-2xl font-bold text-slate-800">
                {{ $company->name }}
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Company details and information.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.companies.edit', $company) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
            <a href="{{ route('admin.companies.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    {{-- Company Details --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Main Information --}}
        <div class="lg:col-span-2 rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-800">
                    Company Information
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-6 p-6 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Company Name
                    </p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $company->name }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Company Code
                    </p>
                    <p class="mt-1">
                        <span class="rounded-md bg-blue-50 px-2.5 py-1 text-sm font-semibold text-blue-700">
                            {{ $company->code }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Phone
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $company->phone ?: '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Email
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $company->email ?: '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Status
                    </p>
                    <p class="mt-1">
                        @if($company->status)
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
                <div>
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Created
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $company->created_at?->format('d M Y, h:i A') }}
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium uppercase text-slate-400">
                        Address
                    </p>
                    <p class="mt-1 whitespace-pre-line text-slate-700">
                        {{ $company->address ?: '-' }}
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
            <div class="space-y-5 p-6">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">
                        Total Branches
                    </p>
                    <p class="mt-1 text-2xl font-bold text-slate-800">
                        {{ $company->branches->count() }}
                    </p>
                </div>
                <div class="rounded-lg bg-blue-50 p-4">
                    <p class="text-sm text-blue-600">
                        Company Code
                    </p>
                    <p class="mt-1 text-lg font-bold text-blue-800">
                        {{ $company->code }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    {{-- Branches --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="font-semibold text-slate-800">
                    Branches
                </h2>
                <p class="mt-1 text-xs text-slate-500">
                    Branches under this company.
                </p>
            </div>
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                {{ $company->branches->count() }} Branches
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-200 bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-slate-600">
                            #
                        </th>
                        <th class="px-6 py-4 font-semibold text-slate-600">
                            Branch
                        </th>
                        <th class="px-6 py-4 font-semibold text-slate-600">
                            Code
                        </th>
                        <th class="px-6 py-4 font-semibold text-slate-600">
                            Phone
                        </th>
                        <th class="px-6 py-4 font-semibold text-slate-600">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                   @forelse($company->branches as $branch)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">
                               {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $branch->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-md bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                    {{ $branch->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $branch->phone ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                                No branches found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection