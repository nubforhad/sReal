@extends('admin.layouts.app')

@section('title', 'Add Land Share Payment')
@section('page-title', 'Add Land Share Payment')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Add Land Share Payment
            </h1>
            <p class="text-sm text-slate-500">
                Record a payment against an existing land share sale.
            </p>
        </div>

        <a href="{{ route('admin.land-share-payments.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <div class="flex gap-3">
                <i class="bi bi-exclamation-triangle-fill text-red-600"></i>

                <div>
                    <h3 class="font-semibold text-red-800">
                        Please fix the following errors:
                    </h3>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.land-share-payments.store') }}"
          id="paymentForm">

        @csrf

        {{-- Business Assignment --}}
        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Business Assignment
                </h2>
                <p class="text-xs text-slate-500">
                    Select company, branch and project.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Company --}}
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
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Branch --}}
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
                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Project --}}
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
                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- Sale Selection --}}
        <div class="erp-card mt-6 overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Land Share Sale
                </h2>

                <p class="text-xs text-slate-500">
                    Select the sale against which this payment will be received.
                </p>
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

                        <option
                            value="{{ $sale->id }}"
                            data-company="{{ $sale->company_id }}"
                            data-branch="{{ $sale->branch_id }}"
                            data-project="{{ $sale->project_id }}"
                            data-client="{{ $sale->client?->name }}"
                            data-phone="{{ $sale->client?->phone }}"
                            data-land="{{ $sale->land?->land_name ?? $sale->land?->land_code }}"
                            data-price="{{ (float) $sale->land_share_price }}"
                            data-paid="{{ (float) $sale->paid_amount }}"
                            data-due="{{ (float) $sale->due_amount }}"
                            data-percentage="{{ (float) $sale->payment_percentage }}"
                            data-eligible="{{ $sale->registration_eligible ? '1' : '0' }}"
                            {{ old('land_share_sale_id') == $sale->id ? 'selected' : '' }}
                        >
                            {{ $sale->sale_code }}
                            —
                            {{ $sale->client?->name ?? 'N/A' }}
                            —
                            ৳ {{ number_format((float) $sale->land_share_price, 2) }}
                        </option>

                    @endforeach
                </select>

                <p class="mt-1.5 text-xs text-slate-500">
                    Only confirmed/completed land share sales are available.
                </p>

            </div>

            {{-- Sale Summary --}}
            <div id="saleSummary"
                 class="hidden border-t border-slate-200 bg-slate-50 p-5">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Client</p>
                        <p id="summaryClient"
                           class="mt-1 font-semibold text-slate-800">
                            -
                        </p>
                        <p id="summaryPhone"
                           class="mt-1 text-xs text-slate-500">
                        </p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Land</p>
                        <p id="summaryLand"
                           class="mt-1 font-semibold text-slate-800">
                            -
                        </p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Total Price</p>
                        <p id="summaryPrice"
                           class="mt-1 text-lg font-bold text-blue-700">
                            ৳ 0.00
                        </p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-4">
                        <p class="text-xs text-slate-500">Paid Amount</p>
                        <p id="summaryPaid"
                           class="mt-1 text-lg font-bold text-emerald-700">
                            ৳ 0.00
                        </p>
                    </div>

                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">

                    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                        <p class="text-xs text-amber-700">Current Due</p>
                        <p id="summaryDue"
                           class="mt-1 text-xl font-bold text-amber-700">
                            ৳ 0.00
                        </p>
                    </div>

                    <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                        <p class="text-xs text-blue-700">Payment Percentage</p>
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

                {{-- Payment Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Payment Date <span class="text-red-500">*</span>
                    </label>

                    <input type="date"
                           name="payment_date"
                           value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- Amount --}}
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
                               value="{{ old('amount') }}"
                               required
                               placeholder="Enter payment amount"
                               class="w-full rounded-lg border border-slate-300 py-2.5 pl-8 pr-3 text-sm">
                    </div>

                    <p id="amountHelp"
                       class="mt-1.5 text-xs text-slate-500">
                        Select a sale to see the current due amount.
                    </p>
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Payment Method <span class="text-red-500">*</span>
                    </label>

                    <select name="payment_method"
                            id="payment_method"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="">Select Method</option>

                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>
                            Bank
                        </option>

                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>
                            Cheque
                        </option>

                        <option value="mobile_banking" {{ old('payment_method') == 'mobile_banking' ? 'selected' : '' }}>
                            Mobile Banking
                        </option>

                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>
                            Online
                        </option>

                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>
                            Other
                        </option>

                    </select>
                </div>

                {{-- Transaction --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Transaction No
                    </label>

                    <input type="text"
                           name="transaction_no"
                           value="{{ old('transaction_no') }}"
                           placeholder="Transaction/reference number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- Bank --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Bank Name
                    </label>

                    <input type="text"
                           name="bank_name"
                           value="{{ old('bank_name') }}"
                           placeholder="Bank name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- Cheque --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Cheque No
                    </label>

                    <input type="text"
                           name="cheque_no"
                           value="{{ old('cheque_no') }}"
                           placeholder="Cheque number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                {{-- Remarks --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              rows="4"
                              placeholder="Payment remarks..."
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('remarks') }}</textarea>
                </div>

            </div>

        </div>

        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-share-payments.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    id="submitBtn"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg"></i>
                Save Payment
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

    const saleSummary = document.getElementById('saleSummary');

    const amountInput = document.getElementById('amount');
    const amountHelp = document.getElementById('amountHelp');

    const submitBtn = document.getElementById('submitBtn');

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

        if (
            branchSelect.value &&
            companyId &&
            branchSelect.options[branchSelect.selectedIndex]?.dataset.company !== companyId
        ) {
            branchSelect.value = '';
        }
    }

    function filterProjects() {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const companyMatch =
                !companyId || option.dataset.company === companyId;

            const branchMatch =
                !branchId || option.dataset.branch === branchId;

            option.hidden = !(companyMatch && branchMatch);
        });

        if (
            projectSelect.value &&
            projectSelect.options[projectSelect.selectedIndex]?.hidden
        ) {
            projectSelect.value = '';
        }
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

            const companyMatch =
                !companyId || option.dataset.company === companyId;

            const branchMatch =
                !branchId || option.dataset.branch === branchId;

            const projectMatch =
                !projectId || option.dataset.project === projectId;

            option.hidden =
                !(companyMatch && branchMatch && projectMatch);
        });

        if (
            saleSelect.value &&
            saleSelect.options[saleSelect.selectedIndex]?.hidden
        ) {
            saleSelect.value = '';
        }

        updateSaleSummary();
    }

    function formatMoney(value) {

        return new Intl.NumberFormat('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(value);
    }

    function updateSaleSummary() {

        const option =
            saleSelect.options[saleSelect.selectedIndex];

        if (!saleSelect.value || !option || option.hidden) {

            saleSummary.classList.add('hidden');

            amountInput.max = '';
            amountHelp.textContent =
                'Select a sale to see the current due amount.';

            return;
        }

        const client = option.dataset.client || 'N/A';
        const phone = option.dataset.phone || '';
        const land = option.dataset.land || 'N/A';

        const price = parseFloat(option.dataset.price || 0);
        const paid = parseFloat(option.dataset.paid || 0);
        const due = parseFloat(option.dataset.due || 0);
        const percentage = parseFloat(option.dataset.percentage || 0);

        const eligible = option.dataset.eligible === '1';

        document.getElementById('summaryClient').textContent = client;
        document.getElementById('summaryPhone').textContent = phone;
        document.getElementById('summaryLand').textContent = land;

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

        if (eligible) {

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

        if (due > 0) {

            amountHelp.textContent =
                'Maximum payment allowed: ৳ ' +
                formatMoney(due);

        } else {

            amountHelp.textContent =
                'This sale has no remaining due amount.';
        }

        saleSummary.classList.remove('hidden');

        validateAmount();
    }

    function validateAmount() {

        const option =
            saleSelect.options[saleSelect.selectedIndex];

        if (!saleSelect.value || !option) {
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

        } else {

            amountInput.classList.remove(
                'border-red-500',
                'ring-2',
                'ring-red-100'
            );

            submitBtn.disabled = false;

            return true;
        }
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

    saleSelect.addEventListener('change', updateSaleSummary);

    amountInput.addEventListener('input', validateAmount);

    document.getElementById('paymentForm').addEventListener('submit', function (event) {

        if (!validateAmount()) {

            event.preventDefault();

            if (typeof Swal !== 'undefined') {

                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Payment amount cannot exceed the current due amount.'
                });

            } else {

                alert('Payment amount cannot exceed the current due amount.');

            }
        }

    });

    filterBranches();
    filterProjects();
    filterSales();
    updateSaleSummary();

});
</script>
@endpush