@extends('admin.layouts.app')

@section('title', 'Edit Land Share Payment')
@section('page-title', 'Edit Land Share Payment')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Edit Land Share Payment
            </h1>

            <p class="text-sm text-slate-500">
                Update payment receipt {{ $landSharePayment->receipt_no }}.
            </p>
        </div>

        <a href="{{ route('admin.land-share-payments.show', $landSharePayment) }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">

            <h3 class="font-semibold text-red-800">
                Please fix the following errors:
            </h3>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.land-share-payments.update', $landSharePayment) }}"
          id="paymentForm">

        @csrf
        @method('PUT')

        {{-- Business Assignment --}}
        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Business Assignment
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select name="company_id"
                            id="company_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id', $landSharePayment->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>

                    <select name="branch_id"
                            id="branch_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                data-company="{{ $branch->company_id }}"
                                {{ old('branch_id', $landSharePayment->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>

                    <select name="project_id"
                            id="project_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ old('project_id', $landSharePayment->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

            </div>
        </div>

        {{-- Sale --}}
        <div class="erp-card mt-6 overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Land Share Sale
                </h2>
            </div>

            <div class="p-5">

                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Land Share Sale <span class="text-red-500">*</span>
                </label>

                <select name="land_share_sale_id"
                        id="land_share_sale_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                    <option value="">Select Land Share Sale</option>

                    @foreach($sales as $sale)

                        @php
                            $selectedSale = $landSharePayment->land_share_sale_id == $sale->id;

                            $salePaid = (float) $sale->paid_amount;

                            if ($selectedSale) {
                                $salePaid -= (float) $landSharePayment->amount;
                            }

                            $salePaid = max(0, $salePaid);

                            $saleDue = max(
                                0,
                                (float) $sale->land_share_price - $salePaid
                            );

                            $salePercentage = (float) $sale->land_share_price > 0
                                ? min(
                                    100,
                                    ($salePaid / (float) $sale->land_share_price) * 100
                                )
                                : 0;

                            $saleEligible = $salePaid >= (float) $sale->land_share_price;
                        @endphp

                        <option
                            value="{{ $sale->id }}"
                            data-company="{{ $sale->company_id }}"
                            data-branch="{{ $sale->branch_id }}"
                            data-project="{{ $sale->project_id }}"
                            data-client="{{ $sale->client?->name }}"
                            data-phone="{{ $sale->client?->phone }}"
                            data-land="{{ $sale->land?->land_name ?? $sale->land?->land_code }}"
                            data-price="{{ (float) $sale->land_share_price }}"
                            data-paid="{{ $salePaid }}"
                            data-due="{{ $saleDue }}"
                            data-percentage="{{ $salePercentage }}"
                            data-eligible="{{ $saleEligible ? '1' : '0' }}"
                            {{ old('land_share_sale_id', $landSharePayment->land_share_sale_id) == $sale->id ? 'selected' : '' }}>
                            {{ $sale->sale_code }}
                            —
                            {{ $sale->client?->name ?? 'N/A' }}
                            —
                            ৳ {{ number_format((float) $sale->land_share_price, 2) }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div id="saleSummary"
                 class="border-t border-slate-200 bg-slate-50 p-5">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Client</p>
                        <p id="summaryClient"
                           class="mt-1 font-semibold text-slate-800">-</p>
                        <p id="summaryPhone"
                           class="mt-1 text-xs text-slate-500"></p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Land</p>
                        <p id="summaryLand"
                           class="mt-1 font-semibold text-slate-800">-</p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Total Price</p>
                        <p id="summaryPrice"
                           class="mt-1 text-lg font-bold text-blue-700">
                            ৳ 0.00
                        </p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">
                            Paid Before Current Payment
                        </p>

                        <p id="summaryPaid"
                           class="mt-1 text-lg font-bold text-emerald-700">
                            ৳ 0.00
                        </p>
                    </div>

                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">

                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                        <p class="text-xs text-amber-700">
                            Available Due
                        </p>

                        <p id="summaryDue"
                           class="mt-1 text-xl font-bold text-amber-700">
                            ৳ 0.00
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <p class="text-xs text-blue-700">
                            Percentage
                        </p>

                        <p id="summaryPercentage"
                           class="mt-1 text-xl font-bold text-blue-700">
                            0%
                        </p>
                    </div>

                    <div id="eligibilityBox"
                         class="rounded-lg border border-slate-200 bg-white p-4">

                        <p class="text-xs text-slate-500">
                            Registration Eligibility
                        </p>

                        <p id="summaryEligibility"
                           class="mt-1 font-bold text-slate-700">
                            Not Eligible
                        </p>

                    </div>

                </div>

            </div>
        </div>

        {{-- Payment Details --}}
        <div class="erp-card mt-6 overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Payment Details
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Receipt No
                    </label>

                    <input type="text"
                           value="{{ $landSharePayment->receipt_no }}"
                           readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-600">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Payment Date <span class="text-red-500">*</span>
                    </label>

                    <input type="date"
                           name="payment_date"
                           value="{{ old('payment_date', $landSharePayment->payment_date?->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Payment Amount <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">
                            ৳
                        </span>

                        <input type="number"
                               step="0.01"
                               min="0.01"
                               name="amount"
                               id="amount"
                               value="{{ old('amount', $landSharePayment->amount) }}"
                               required
                               class="w-full rounded-lg border border-slate-300 py-2.5 pl-8 pr-3 text-sm">
                    </div>

                    <p id="amountHelp"
                       class="mt-1.5 text-xs text-slate-500">
                    </p>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Payment Method <span class="text-red-500">*</span>
                    </label>

                    <select name="payment_method"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="">Select Method</option>

                        @foreach([
                            'cash' => 'Cash',
                            'bank' => 'Bank',
                            'cheque' => 'Cheque',
                            'mobile_banking' => 'Mobile Banking',
                            'online' => 'Online',
                            'other' => 'Other',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('payment_method', $landSharePayment->payment_method) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Transaction No
                    </label>

                    <input type="text"
                           name="transaction_no"
                           value="{{ old('transaction_no', $landSharePayment->transaction_no) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Bank Name
                    </label>

                    <input type="text"
                           name="bank_name"
                           value="{{ old('bank_name', $landSharePayment->bank_name) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Cheque No
                    </label>

                    <input type="text"
                           name="cheque_no"
                           value="{{ old('cheque_no', $landSharePayment->cheque_no) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              rows="4"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('remarks', $landSharePayment->remarks) }}</textarea>
                </div>

            </div>
        </div>

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-share-payments.show', $landSharePayment) }}"
               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    id="submitBtn"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg"></i>
                Update Payment
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');
    const saleSelect = document.getElementById('land_share_sale_id');

    const amountInput = document.getElementById('amount');
    const amountHelp = document.getElementById('amountHelp');
    const submitBtn = document.getElementById('submitBtn');

    function formatMoney(value) {
        return new Intl.NumberFormat('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }

    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                companyId &&
                option.dataset.company !== companyId;
        });
    }

    function filterProjects() {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                (companyId && option.dataset.company !== companyId) ||
                (branchId && option.dataset.branch !== branchId);
        });
    }

    function filterSales() {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;
        const projectId = projectSelect.value;

        Array.from(saleSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                (companyId && option.dataset.company !== companyId) ||
                (branchId && option.dataset.branch !== branchId) ||
                (projectId && option.dataset.project !== projectId);
        });
    }

    function updateSummary() {

        const option =
            saleSelect.options[saleSelect.selectedIndex];

        if (!saleSelect.value || !option) {
            return;
        }

        const price = parseFloat(option.dataset.price || 0);
        const paid = parseFloat(option.dataset.paid || 0);
        const due = parseFloat(option.dataset.due || 0);
        const percentage = parseFloat(option.dataset.percentage || 0);

        document.getElementById('summaryClient').textContent =
            option.dataset.client || 'N/A';

        document.getElementById('summaryPhone').textContent =
            option.dataset.phone || '';

        document.getElementById('summaryLand').textContent =
            option.dataset.land || 'N/A';

        document.getElementById('summaryPrice').textContent =
            '৳ ' + formatMoney(price);

        document.getElementById('summaryPaid').textContent =
            '৳ ' + formatMoney(paid);

        document.getElementById('summaryDue').textContent =
            '৳ ' + formatMoney(due);

        document.getElementById('summaryPercentage').textContent =
            percentage.toFixed(2) + '%';

        const eligibility =
            document.getElementById('summaryEligibility');

        const eligibilityBox =
            document.getElementById('eligibilityBox');

        if (option.dataset.eligible === '1') {

            eligibility.textContent = 'Eligible for Registration';

            eligibility.className =
                'mt-1 font-bold text-emerald-700';

            eligibilityBox.className =
                'rounded-lg border border-emerald-200 bg-emerald-50 p-4';

        } else {

            eligibility.textContent = 'Not Eligible';

            eligibility.className =
                'mt-1 font-bold text-amber-700';

            eligibilityBox.className =
                'rounded-lg border border-amber-200 bg-amber-50 p-4';
        }

        amountInput.max = due;

        amountHelp.textContent =
            'Maximum payment allowed: ৳ ' +
            formatMoney(due);

        validateAmount();
    }

    function validateAmount() {

        const option =
            saleSelect.options[saleSelect.selectedIndex];

        if (!option || !saleSelect.value) {
            submitBtn.disabled = false;
            return true;
        }

        const due = parseFloat(option.dataset.due || 0);
        const amount = parseFloat(amountInput.value || 0);

        if (amount > due) {

            amountInput.classList.add(
                'border-red-500',
                'ring-2',
                'ring-red-100'
            );

            submitBtn.disabled = true;

            return false;
        }

        amountInput.classList.remove(
            'border-red-500',
            'ring-2',
            'ring-red-100'
        );

        submitBtn.disabled = false;

        return true;
    }

    companySelect.addEventListener('change', function () {
        branchSelect.value = '';
        projectSelect.value = '';
        saleSelect.value = '';

        filterBranches();
        filterProjects();
        filterSales();
    });

    branchSelect.addEventListener('change', function () {
        projectSelect.value = '';
        saleSelect.value = '';

        filterProjects();
        filterSales();
    });

    projectSelect.addEventListener('change', function () {
        saleSelect.value = '';
        filterSales();
    });

    saleSelect.addEventListener('change', updateSummary);

    amountInput.addEventListener('input', validateAmount);

    document.getElementById('paymentForm').addEventListener('submit', function (event) {

        if (!validateAmount()) {

            event.preventDefault();

            if (typeof Swal !== 'undefined') {

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Payment amount cannot exceed the available due amount.'
                });

            } else {
                alert('Payment amount cannot exceed the available due amount.');
            }
        }

    });

    filterBranches();
    filterProjects();
    filterSales();
    updateSummary();

});
</script>
@endpush