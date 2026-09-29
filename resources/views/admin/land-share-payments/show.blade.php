@extends('admin.layouts.app')

@section('title', 'Payment Receipt')
@section('page-title', 'Land Share Payment Receipt')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Top Actions --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">

        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Payment Receipt
            </h1>

            <p class="text-sm text-slate-500">
                {{ $landSharePayment->receipt_no }}
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-900">
                <i class="bi bi-printer"></i>
                Print
            </button>

            <a href="{{ route('admin.land-share-payments.edit', $landSharePayment) }}"
               class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-amber-600">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>

            <a href="{{ route('admin.land-share-payments.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>

    @php
        $sale = $landSharePayment->landShareSale;

        $totalPrice = (float) ($sale?->land_share_price ?? 0);

        $paidAmount = $sale
            ? (float) $sale->payments()
                ->where('id', '<=', $landSharePayment->id)
                ->sum('amount')
            : 0;

        $dueAmount = max(0, $totalPrice - $paidAmount);

        $percentage = $totalPrice > 0
            ? min(100, ($paidAmount / $totalPrice) * 100)
            : 0;

        $eligible = $paidAmount >= $totalPrice;

        $methodLabels = [
            'cash' => 'Cash',
            'bank' => 'Bank',
            'cheque' => 'Cheque',
            'mobile_banking' => 'Mobile Banking',
            'online' => 'Online',
            'other' => 'Other',
        ];
    @endphp

    {{-- Receipt --}}
    <div id="printReceipt"
         class="erp-card overflow-hidden bg-white">

        {{-- Print Header --}}
        <div class="border-b border-slate-200 px-6 py-6 sm:px-8">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $landSharePayment->company?->name ?? 'Real Estate Company' }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Land Share Payment Receipt
                    </p>

                    @if($landSharePayment->branch)
                        <p class="mt-1 text-sm text-slate-600">
                            Branch:
                            <span class="font-medium">
                                {{ $landSharePayment->branch->name }}
                            </span>
                        </p>
                    @endif
                </div>

                <div class="text-left sm:text-right">

                    <p class="text-xs uppercase tracking-wide text-slate-500">
                        Receipt No
                    </p>

                    <p class="mt-1 text-xl font-bold text-blue-700">
                        {{ $landSharePayment->receipt_no }}
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $landSharePayment->payment_date?->format('d M Y') }}
                    </p>

                </div>

            </div>

        </div>

        {{-- Project / Client --}}
        <div class="grid grid-cols-1 gap-6 border-b border-slate-200 p-6 sm:grid-cols-2 sm:px-8">

            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                    Project Information
                </h3>

                <div class="space-y-2 text-sm">

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Project</span>
                        <span class="font-semibold text-slate-800">
                            {{ $landSharePayment->project?->project_name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Branch</span>
                        <span class="font-medium text-slate-700">
                            {{ $landSharePayment->branch?->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Sale Code</span>
                        <span class="font-semibold text-blue-700">
                            {{ $sale?->sale_code ?? 'N/A' }}
                        </span>
                    </div>

                </div>
            </div>

            <div>
                <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                    Client Information
                </h3>

                <div class="space-y-2 text-sm">

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Name</span>
                        <span class="font-semibold text-slate-800">
                            {{ $landSharePayment->client?->name ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Phone</span>
                        <span class="font-medium text-slate-700">
                            {{ $landSharePayment->client?->phone ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-slate-500">Client ID</span>
                        <span class="font-medium text-slate-700">
                            {{ $landSharePayment->client?->client_code ?? 'N/A' }}
                        </span>
                    </div>

                </div>
            </div>

        </div>

        {{-- Land Information --}}
        <div class="border-b border-slate-200 p-6 sm:px-8">

            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Land Information
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Land Code</p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $sale?->land?->land_code ?? 'N/A' }}
                    </p>
                </div>

                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Land Name</p>
                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $sale?->land?->land_name ?? 'N/A' }}
                    </p>
                </div>

                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Share Price</p>
                    <p class="mt-1 font-bold text-blue-700">
                        ৳ {{ number_format($totalPrice, 2) }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Payment Details --}}
        <div class="border-b border-slate-200 p-6 sm:px-8">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Current Payment
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div>
                    <p class="text-xs text-slate-500">
                        Payment Date
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landSharePayment->payment_date?->format('d M Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Payment Method
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $methodLabels[$landSharePayment->payment_method] ?? ucfirst($landSharePayment->payment_method) }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Transaction No
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $landSharePayment->transaction_no ?: 'N/A' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">
                        Payment Amount
                    </p>

                    <p class="mt-1 text-xl font-bold text-emerald-700">
                        ৳ {{ number_format((float) $landSharePayment->amount, 2) }}
                    </p>
                </div>

            </div>

            @if($landSharePayment->bank_name || $landSharePayment->cheque_no)

                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    @if($landSharePayment->bank_name)
                        <div>
                            <p class="text-xs text-slate-500">
                                Bank Name
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ $landSharePayment->bank_name }}
                            </p>
                        </div>
                    @endif

                    @if($landSharePayment->cheque_no)
                        <div>
                            <p class="text-xs text-slate-500">
                                Cheque No
                            </p>

                            <p class="mt-1 font-medium text-slate-700">
                                {{ $landSharePayment->cheque_no }}
                            </p>
                        </div>
                    @endif

                </div>

            @endif

        </div>

        {{-- Payment Summary --}}
        <div class="border-b border-slate-200 bg-slate-50 p-6 sm:px-8">

            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                Land Share Payment Summary
            </h3>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <p class="text-xs text-blue-700">
                        Total Land Share Price
                    </p>

                    <p class="mt-1 text-xl font-bold text-blue-700">
                        ৳ {{ number_format($totalPrice, 2) }}
                    </p>
                </div>

                <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">
                    <p class="text-xs text-emerald-700">
                        Total Paid
                    </p>

                    <p class="mt-1 text-xl font-bold text-emerald-700">
                        ৳ {{ number_format($paidAmount, 2) }}
                    </p>
                </div>

                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <p class="text-xs text-amber-700">
                        Remaining Due
                    </p>

                    <p class="mt-1 text-xl font-bold text-amber-700">
                        ৳ {{ number_format($dueAmount, 2) }}
                    </p>
                </div>

            </div>

            <div class="mt-5">

                <div class="mb-2 flex items-center justify-between text-sm">
                    <span class="font-medium text-slate-600">
                        Payment Progress
                    </span>

                    <span class="font-bold text-slate-800">
                        {{ number_format($percentage, 2) }}%
                    </span>
                </div>

                <div class="h-3 overflow-hidden rounded-full bg-slate-200">

                    <div class="h-full rounded-full bg-blue-600 transition-all"
                         style="width: {{ min(100, $percentage) }}%">
                    </div>

                </div>

            </div>

            <div class="mt-5">

                @if($eligible)

                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-center">

                        <i class="bi bi-check-circle-fill text-2xl text-emerald-600"></i>

                        <p class="mt-2 font-bold text-emerald-700">
                            Registration Eligible
                        </p>

                        <p class="mt-1 text-sm text-emerald-600">
                            Land share payment has reached 100%.
                        </p>

                    </div>

                @else

                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-center">

                        <i class="bi bi-hourglass-split text-2xl text-amber-600"></i>

                        <p class="mt-2 font-bold text-amber-700">
                            Registration Not Eligible
                        </p>

                        <p class="mt-1 text-sm text-amber-600">
                            Full land share payment is required before registration.
                        </p>

                    </div>

                @endif

            </div>

        </div>

        @if($landSharePayment->remarks)

            <div class="border-b border-slate-200 p-6 sm:px-8">

                <h3 class="mb-2 text-sm font-semibold uppercase tracking-wide text-slate-500">
                    Remarks
                </h3>

                <p class="whitespace-pre-line text-sm text-slate-700">
                    {{ $landSharePayment->remarks }}
                </p>

            </div>

        @endif

        {{-- Signatures --}}
        <div class="hidden p-8 print:block">

            <div class="mt-16 grid grid-cols-3 gap-10 text-center text-sm">

                <div>
                    <div class="border-t border-slate-400 pt-2">
                        Client Signature
                    </div>
                </div>

                <div>
                    <div class="border-t border-slate-400 pt-2">
                        Accounts Officer
                    </div>
                </div>

                <div>
                    <div class="border-t border-slate-400 pt-2">
                        Authorized Signature
                    </div>
                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div class="bg-slate-50 px-6 py-4 text-center text-xs text-slate-500 sm:px-8">
            This is a computer-generated payment receipt.
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
        background: #ffffff !important;
    }

    .print\:hidden {
        display: none !important;
    }

    .print\:block {
        display: block !important;
    }

    #printReceipt {
        width: 100%;
        border: 1px solid #cbd5e1;
        box-shadow: none !important;
    }

    .erp-card {
        box-shadow: none !important;
    }
}
</style>
@endpush