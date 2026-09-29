@extends('admin.layouts.app')

@section('title', 'Land Share Sale Details')
@section('page-title', 'Land Share Sale Details')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">
    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex flex-wrap items-center gap-3">
                <h1 class="text-xl font-bold text-slate-800">
                    {{ $landShareSale->sale_code }}
                </h1>
                @php
                    $statusClasses = match($landShareSale->status) {
                        'draft' => 'bg-slate-100 text-slate-700',
                        'confirmed' => 'bg-blue-100 text-blue-700',
                        'completed' => 'bg-green-100 text-green-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                @endphp
                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses }}">
                    {{ ucfirst($landShareSale->status) }}
                </span>
            </div>
            <p class="mt-1 text-sm text-slate-500">
                Land Share Sale Details
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-printer"></i>
                Print
            </button>
            <a href="{{ route('admin.land-share-sales.edit', $landShareSale) }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
            <a href="{{ route('admin.land-share-sales.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>

    {{-- Sale Summary --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="erp-card p-5">
            <p class="text-sm text-slate-500">
                Land Share
            </p>
            <p class="mt-2 text-2xl font-bold text-slate-800">
                {{ number_format((float) $landShareSale->share_size, 4) }}
            </p>
            <p class="text-sm text-slate-500">
                {{ $landShareSale->share_unit }}
            </p>
        </div>

        <div class="erp-card p-5">
            <p class="text-sm text-slate-500">
                Price Per Unit
            </p>
            <p class="mt-2 text-2xl font-bold text-slate-800">
                ৳ {{ number_format((float) $landShareSale->price_per_unit, 2) }}
            </p>
            <p class="text-sm text-slate-500">
                Per {{ $landShareSale->share_unit }}
            </p>
        </div>
        <div class="erp-card border-blue-200 bg-blue-50 p-5">
            <p class="text-sm text-blue-700">
                Total Land Share Price
            </p>
            <p class="mt-2 text-2xl font-bold text-blue-800">
                ৳ {{ number_format((float) $landShareSale->land_share_price, 2) }}
            </p>
            <p class="text-sm text-blue-600">
                Payment ledger will be linked later
            </p>
        </div>
    </div>

    {{-- Business Information --}}
    <div class="erp-card">
        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                Business Information
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">
            <div>
                <p class="text-xs uppercase text-slate-500">  Company </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $landShareSale->company?->name ?? 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-xs uppercase text-slate-500">  Branch </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $landShareSale->branch?->name ?? 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-xs uppercase text-slate-500"> Project  </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $landShareSale->project?->project_name ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Client & Land --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Client --}}
        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    Client Information
                </h2>

            </div>

            <div class="space-y-4 p-5">

                <div>
                    <p class="text-xs uppercase text-slate-500">
                        Client Name
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landShareSale->client?->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="text-xs uppercase text-slate-500">
                            Client ID
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $landShareSale->client?->client_code ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-slate-500">
                            Phone
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $landShareSale->client?->phone ?? 'N/A' }}
                        </p>
                    </div>

                </div>

                <div>
                    <p class="text-xs uppercase text-slate-500">
                        NID
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $landShareSale->client?->nid ?? 'N/A' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Land --}}
        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    Land Information
                </h2>

            </div>

            <div class="space-y-4 p-5">

                <div>
                    <p class="text-xs uppercase text-slate-500">
                        Land Code
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landShareSale->land?->land_code ?? 'N/A' }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="text-xs uppercase text-slate-500">
                            Land Name
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $landShareSale->land?->land_name ?? 'N/A' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs uppercase text-slate-500">
                            Land Unit
                        </p>

                        <p class="mt-1 text-sm text-slate-700">
                            {{ $landShareSale->land?->land_unit ?? 'N/A' }}
                        </p>
                    </div>

                </div>

                <div>
                    <p class="text-xs uppercase text-slate-500">
                        Location
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $landShareSale->land?->district ?? 'N/A' }}
                        @if($landShareSale->land?->upazila)
                            , {{ $landShareSale->land->upazila }}
                        @endif
                        @if($landShareSale->land?->mouza)
                            , {{ $landShareSale->land->mouza }}
                        @endif
                    </p>
                </div>

            </div>

        </div>

    </div>

    {{-- Sale Details --}}
    <div class="erp-card">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-800">
                Sale Details
            </h2>

        </div>

        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-4">

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Sale Code
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ $landShareSale->sale_code }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Sale Date
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $landShareSale->sale_date?->format('d M Y') }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Share Size
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ number_format((float) $landShareSale->share_size, 4) }}
                    {{ $landShareSale->share_unit }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Total Price
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    ৳ {{ number_format((float) $landShareSale->land_share_price, 2) }}
                </p>
            </div>

        </div>

    </div>

    {{-- Payment Placeholder --}}
    <div class="erp-card border-dashed">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-800">
                Payment Summary
            </h2>

        </div>

        <div class="p-5">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs uppercase text-slate-500">
                        Total Payable
                    </p>

                    <p class="mt-1 text-lg font-bold text-slate-800">
                        ৳ {{ number_format((float) $landShareSale->land_share_price, 2) }}
                    </p>
                </div>

                <div class="rounded-lg bg-green-50 p-4">
                    <p class="text-xs uppercase text-green-600">
                        Paid
                    </p>

                    <p class="mt-1 text-lg font-bold text-green-700">
                        ৳ 0.00
                    </p>
                </div>

                <div class="rounded-lg bg-red-50 p-4">
                    <p class="text-xs uppercase text-red-600">
                        Due
                    </p>

                    <p class="mt-1 text-lg font-bold text-red-700">
                        ৳ {{ number_format((float) $landShareSale->land_share_price, 2) }}
                    </p>
                </div>

            </div>

            <div class="mt-4 rounded-lg border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700">
                <i class="bi bi-info-circle mr-1"></i>

                Land Share Payment module will be connected here.
                After 100% payment, this sale will become eligible for land registration.
            </div>

        </div>

    </div>

    {{-- Remarks --}}
    @if($landShareSale->remarks)

        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Remarks
                </h2>
            </div>

            <div class="p-5 text-sm leading-6 text-slate-700">
                {{ $landShareSale->remarks }}
            </div>

        </div>

    @endif

    {{-- System Information --}}
    <div class="erp-card">

        <div class="border-b border-slate-200 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                System Information
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2">

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Created At
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $landShareSale->created_at?->format('d M Y h:i A') }}
                </p>
            </div>

            <div>
                <p class="text-xs uppercase text-slate-500">
                    Last Updated
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $landShareSale->updated_at?->format('d M Y h:i A') }}
                </p>
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
        margin: 12mm;
    }

    body {
        background: #fff !important;
    }

    aside,
    header,
    nav,
    button,
    a,
    .no-print {
        display: none !important;
    }

    .erp-card {
        box-shadow: none !important;
        break-inside: avoid;
    }

    main {
        margin: 0 !important;
        padding: 0 !important;
    }

}
</style>

@endpush