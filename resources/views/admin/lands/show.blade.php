@extends('admin.layouts.app')

@section('title', 'Land Details')
@section('page-title', 'Land Details')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Land Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Complete information of land {{ $land->land_code }}.
            </p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <button type="button"
                onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-900"
            >
                <i class="bi bi-printer"></i>
                Print
            </button>
            <a href="{{ route('admin.lands.edit', $land) }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
            >
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>
            <a href="{{ route('admin.lands.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    {{-- Print Header --}}
    <div class="hidden print:block">
        <div class="border-b-2 border-slate-800 pb-4 text-center">
            <h1 class="text-2xl font-bold text-slate-900">
                LAND INFORMATION
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                Land Code: {{ $land->land_code }}
            </p>
        </div>
    </div>
    {{-- Land Summary --}}
    <div class="erp-card overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                        Land Code
                    </p>
                    <h2 class="mt-1 text-xl font-bold text-slate-800">
                        {{ $land->land_code }}
                    </h2>
                    @if($land->land_name)
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $land->land_name }}
                        </p>
                    @endif
                </div>

                @php
                    $statusClasses = match($land->status) {
                        'available' => 'bg-green-50 text-green-700 border-green-200',
                        'partially_sold' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'fully_sold' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'registered' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                        'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
                        default => 'bg-slate-100 text-slate-600 border-slate-200',
                    };

                    $statusLabel = match($land->status) {
                        'available' => 'Available',
                        'partially_sold' => 'Partially Sold',
                        'fully_sold' => 'Fully Sold',
                        'registered' => 'Registered',
                        'closed' => 'Closed',
                        default => ucfirst(str_replace('_', ' ', $land->status)),
                    };
                @endphp

                <span class="inline-flex w-fit whitespace-nowrap rounded-full border px-3 py-1.5 text-xs font-semibold {{ $statusClasses }}">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Company
                </p>
                <p class="mt-1 font-semibold text-slate-700">
                    {{ $land->company?->name ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Branch
                </p>
                <p class="mt-1 font-semibold text-slate-700">
                    {{ $land->branch?->name ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Project
                </p>
                <p class="mt-1 font-semibold text-slate-700">
                    {{ $land->project?->project_name ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Project Code
                </p>
                <p class="mt-1 font-semibold text-slate-700">
                    {{ $land->project?->project_code ?? '—' }}
                </p>
            </div>
        </div>
    </div>
    {{-- Location & Land Records --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-geo-alt text-blue-600"></i>
                Location & Land Records
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    District
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->district ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Upazila
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->upazila ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Mouza
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->mouza ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Khatian No.
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->khatian_no ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Dag No.
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->dag_no ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    JL No.
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->jl_no ?: '—' }}
                </p>
            </div>
        </div>
    </div>

   {{-- Land Size --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-rulers text-blue-600"></i>
                Land Size
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Total Land Size
                </p>
                <p class="mt-2 text-xl font-bold text-slate-800">
                    @if($land->total_land_size !== null)
                        {{ number_format((float) $land->total_land_size, 4) }}
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Unit
                </p>
                <p class="mt-2 text-xl font-bold capitalize text-slate-800">
                    {{ $land->land_unit ?: '—' }}
                </p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Purchase Price
                </p>
                <p class="mt-2 text-xl font-bold text-slate-800">
                    ৳ {{ number_format((float) $land->purchase_price, 2) }}
                </p>
            </div>
        </div>
    </div>
    {{-- Owner Information --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-person-vcard text-blue-600"></i>
                Land Owner Information
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Owner Name
                </p>
                <p class="mt-1 font-semibold text-slate-700">
                    {{ $land->owner_name ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Owner Phone
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->owner_phone ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Owner NID
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->owner_nid ?: '—' }}
                </p>
           </div>
        </div>
    </div>
    {{-- Purchase Information --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-cash-stack text-blue-600"></i>
                Purchase Information
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-x-8 gap-y-5 p-5 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Purchase Price
                </p>
                <p class="mt-1 text-lg font-bold text-slate-800">
                    ৳ {{ number_format((float) $land->purchase_price, 2) }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Purchase Date
                </p>
                <p class="mt-1 font-medium text-slate-700">
                    {{ $land->purchase_date?->format('d M Y') ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Current Status
                </p>
                <span class="mt-1 inline-flex whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                    {{ $statusLabel }}
                </span>
            </div>
        </div>
    </div>
    {{-- Additional Information --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-card-text text-blue-600"></i>
                Additional Information
            </h2>
        </div>
        <div class="space-y-5 p-5">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Description
               </p>
                <div class="mt-2 rounded-lg bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                   {!! $land->description
                        ? nl2br(e($land->description))
                        : '<span class="text-slate-400">No description available.</span>' !!}
                </div>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Remarks
                </p>
                <div class="mt-2 rounded-lg bg-slate-50 p-4 text-sm leading-6 text-slate-700">
                    {!! $land->remarks
                        ? nl2br(e($land->remarks))
                        : '<span class="text-slate-400">No remarks available.</span>' !!}
                </div>
            </div>
        </div>
    </div>
    {{-- Future Land Business Section --}}
    <div class="erp-card print:hidden">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                <i class="bi bi-diagram-3 text-blue-600"></i>
                Land Business Records
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Sales, payment and registration records related to this land will appear here.
            </p>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 sm:grid-cols-3">
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700">
                            Land Share Sales
                        </p>
                        <p class="text-xs text-slate-500">
                            Coming next
                        </p>
                    </div>
                </div>
            </div>
            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-50 text-green-600">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700">
                            Land Payments
                        </p>
                        <p class="text-xs text-slate-500">
                            Coming next
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700">
                            Land Registration
                        </p>
                        <p class="text-xs text-slate-500">
                            Coming next
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- System Information --}}
    <div class="erp-card print:hidden">
        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2">
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Created At
                </p>
                <p class="mt-1 text-sm font-medium text-slate-700">
                    {{ $land->created_at?->format('d M Y, h:i A') ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Last Updated
                </p>
                <p class="mt-1 text-sm font-medium text-slate-700">
                    {{ $land->updated_at?->format('d M Y, h:i A') ?? '—' }}
                </p>
            </div>
        </div>
    </div>
    {{-- Print Footer --}}
    <div class="hidden print:block">
        <div class="mt-10 border-t border-slate-300 pt-4">
            <div class="grid grid-cols-2 gap-10 text-center">
                <div>
                    <div class="mx-auto mt-10 w-48 border-t border-slate-500"></div>
                    <p class="mt-2 text-sm text-slate-600">
                        Authorized Signature
                    </p>
                </div>
                <div>
                    <div class="mx-auto mt-10 w-48 border-t border-slate-500"></div>
                    <p class="mt-2 text-sm text-slate-600">
                        Client / Owner Signature
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')

<style>
@media print {
    @page {
        size: A4;
        margin: 15mm;
    }
    body {
        background: #ffffff !important;
    }
    .erp-card {
        box-shadow: none !important;
        break-inside: avoid;
    }
    .page-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    a {
        text-decoration: none !important;
    }

}
</style>

@endpush