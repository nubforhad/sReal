@extends('admin.layouts.app')

@section('title', 'Land Registration Details')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-2xl font-bold text-slate-800">
                    {{ $landRegistration->registration_code }}
                </h1>
                @php
                    $statusClasses = [
                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                        'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                        'completed' => 'bg-green-50 text-green-700 border-green-200',
                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                    ];
                @endphp
                <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusClasses[$landRegistration->status] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                    {{ ucfirst($landRegistration->status) }}
                </span>
            </div>
            <p class="mt-1 text-sm text-slate-500">
                Land Registration Details
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.land-registrations.edit', $landRegistration) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>
            <!-- <button type="button"  onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-printer"></i>
                Print
            </button> -->
            <a href="{{ route('admin.land-registrations.print', $landRegistration) }}" target="_blank"  class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="bi bi-printer"></i>
                    Print
            </a>

            <a href="{{ route('admin.land-registrations.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div class="print:hidden rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i class="bi bi-check-circle mr-1"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Main Information --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Registration Summary --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Registration Information
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Registration Code
                    </p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landRegistration->registration_code }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Deed No
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landRegistration->deed_no ?: '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Registration Date
                    </p>

                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->registration_date
                            ? \Carbon\Carbon::parse($landRegistration->registration_date)->format('d M Y')
                            : '—'
                        }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Sub Registry Office
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->sub_registry_office ?: '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Company
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->company?->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Branch
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->branch?->name ?? 'N/A' }}
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Project
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->project?->project_name ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
        {{-- Client --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Client
                </h2>
            </div>
            <div class="space-y-4 p-5">
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Name
                    </p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landRegistration->client?->name ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase text-slate-500">
                        Phone
                    </p>
                    <p class="mt-1 text-slate-700">
                        {{ $landRegistration->client?->phone ?? '—' }}
                    </p>
                </div>
                @if($landRegistration->client?->email)
                    <div>
                        <p class="text-xs font-medium uppercase text-slate-500">
                            Email
                        </p>

                        <p class="mt-1 break-all text-slate-700">
                            {{ $landRegistration->client->email }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Land Information --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                Land Information
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    District
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->district ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Upazila
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->upazila ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Mouza
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->mouza ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Khatian No
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->khatian_no ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Dag No
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->dag_no ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    JL No
                </p>
                <p class="mt-1 text-sm font-medium text-slate-800">
                    {{ $landRegistration->jl_no ?: '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Land Size
                </p>
                <p class="mt-1 text-sm font-semibold text-slate-800">
                    {{ $landRegistration->registered_land_size !== null
                        ? number_format((float) $landRegistration->registered_land_size, 2)
                        : '—'
                    }}
                    {{ $landRegistration->land_unit }}
                </p>
            </div>
        </div>
    </div>

    {{-- Sale & Payment --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                Land Share Sale & Payment
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Sale ID
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    #{{ $landRegistration->landShareSale?->id ?? '—' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Land Share Price
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    ৳ {{ number_format((float) ($landRegistration->landShareSale?->land_share_price ?? 0), 2) }}
                </p>
            </div>
            @php
                $paidAmount = (float) ($landRegistration->landShareSale?->payments?->sum('amount') ?? 0);
                $sharePrice = (float) ($landRegistration->landShareSale?->land_share_price ?? 0);
                $dueAmount = max(0, $sharePrice - $paidAmount);
            @endphp

            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Paid Amount
                </p>
                <p class="mt-1 font-semibold text-green-600">
                    ৳ {{ number_format($paidAmount, 2) }}
                </p>
            </div>
            <div>
                <p class="text-xs font-medium uppercase text-slate-500">
                    Due Amount
                </p>
                <p class="mt-1 font-semibold {{ $dueAmount > 0 ? 'text-red-600' : 'text-green-600' }}">
                    ৳ {{ number_format($dueAmount, 2) }}
                </p>
            </div>
        </div>

        @if($landRegistration->landShareSale?->land)
            <div class="border-t border-slate-200 px-5 py-4">
                <p class="text-xs font-medium uppercase text-slate-500">
                    Land
                </p>
                <p class="mt-1 text-sm text-slate-700">
                    {{ $landRegistration->landShareSale->land->name
                        ?? $landRegistration->landShareSale->land->land_name
                        ?? 'Land #' . $landRegistration->landShareSale->land->id
                    }}
                </p>
            </div>
        @endif

    </div>

    {{-- Costs --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">
                Registration Cost
            </p>
            <p class="mt-2 text-2xl font-bold text-slate-800">
                ৳ {{ number_format((float) $landRegistration->registration_cost, 2) }}
            </p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-sm text-slate-500">
                Other Cost
            </p>
            <p class="mt-2 text-2xl font-bold text-slate-800">
                ৳ {{ number_format((float) $landRegistration->other_cost, 2) }}
            </p>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
            <p class="text-sm text-blue-700">
                Total Registration Cost
            </p>
            <p class="mt-2 text-2xl font-bold text-blue-800">
                ৳ {{ number_format((float) $landRegistration->total_cost, 2) }}
            </p>
        </div>
    </div>

    {{-- Documents --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                Documents
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-4 p-5 md:grid-cols-3">
            {{-- Deed --}}
            <div class="rounded-lg border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50 text-red-600">
                        <i class="bi bi-file-earmark-pdf text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Deed Document
                        </p>
                        @if($landRegistration->deed_document)
                            <a href="{{ asset('storage/' . $landRegistration->deed_document) }}"
                               target="_blank"
                               class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                View Document
                            </a>
                        @else
                            <p class="text-xs text-slate-500">
                                No document uploaded
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Registration --}}
            <div class="rounded-lg border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <i class="bi bi-file-earmark-text text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Registration Document
                        </p>
                        @if($landRegistration->registration_document)
                            <a href="{{ asset('storage/' . $landRegistration->registration_document) }}"
                               target="_blank"
                               class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                View Document
                            </a>
                        @else
                            <p class="text-xs text-slate-500">
                                No document uploaded
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            {{-- Other --}}
            <div class="rounded-lg border border-slate-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <i class="bi bi-file-earmark text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-800">
                            Other Document
                        </p>
                        @if($landRegistration->other_document)
                            <a href="{{ asset('storage/' . $landRegistration->other_document) }}"
                               target="_blank"
                               class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                View Document
                            </a>
                        @else

                            <p class="text-xs text-slate-500">
                                No document uploaded
                            </p>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Remarks --}}
    @if($landRegistration->remarks)
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Remarks
                </h2>
            </div>
            <div class="p-5">
                <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                    {{ $landRegistration->remarks }}
                </p>
            </div>
        </div>
    @endif
</div>

<style>
    @media print {
        body {
            background: white !important;
        }

        .print\:hidden {
            display: none !important;
        }

        nav,
        aside,
        header {
            display: none !important;
        }

        .shadow-sm {
            box-shadow: none !important;
        }

        .border {
            border-color: #cbd5e1 !important;
        }
    }
</style>

@endsection