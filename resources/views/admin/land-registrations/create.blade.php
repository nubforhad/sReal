@extends('admin.layouts.app')

@section('title', 'Create Land Registration')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Create Land Registration
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Register land after complete land share payment.
            </p>
        </div>

        <a href="{{ route('admin.land-registrations.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>
    </div>

    {{-- Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.land-registrations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- =========  BASIC INFORMATION ========= --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Basic Information
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">
                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select name="company_id" id="company_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                data-company="{{ $company->id }}"
                                @selected(old('company_id') == $company->id)>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Branch --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>
                    <select name="branch_id"  id="branch_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    data-company="{{ $branch->company_id }}"
                                    @selected(old('branch_id') == $branch->id)>
                                {{ $branch->name }}

                                @if($branch->company)
                                    — {{ $branch->company->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('branch_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Project --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id"  id="project_id"  required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                    @selected(old('project_id') == $project->id)>
                                {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                {{-- ======== LAND SHARE SALE ====== --}}
                <div class="md:col-span-2 lg:col-span-3">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Share Sale <span class="text-red-500">*</span>
                    </label>
                    <select name="land_share_sale_id" id="land_share_sale_id" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">
                            Select Fully Paid Land Share Sale
                        </option>
                        @foreach($sales as $sale)

                            @php
                                $price = (float) $sale->land_share_price;
                                $paid = (float) $sale->payments->sum('amount');

                                $due = max(0, $price - $paid);

                                $percentage = $price > 0
                                    ? ($paid / $price) * 100
                                    : 0;

                                $isFullyPaid = $due <= 0.01;
                            @endphp

                            {{-- Only fully paid sales --}}
                            @if($isFullyPaid)

                                <option value="{{ $sale->id }}"
                                        data-company="{{ $sale->company_id }}"
                                        data-branch="{{ $sale->branch_id }}"
                                        data-project="{{ $sale->project_id }}"

                                        data-sale-code="{{ $sale->sale_code ?? 'Sale #'.$sale->id }}"

                                        data-client-id="{{ $sale->client_id }}"
                                        data-client="{{ $sale->client?->name ?? 'N/A' }}"
                                        data-phone="{{ $sale->client?->phone ?? '' }}"
                                        data-email="{{ $sale->client?->email ?? '' }}"

                                        data-price="{{ number_format($price, 2, '.', '') }}"
                                        data-paid="{{ number_format($paid, 2, '.', '') }}"
                                        data-due="{{ number_format($due, 2, '.', '') }}"
                                        data-percentage="{{ number_format($percentage, 2, '.', '') }}"

                                        data-land="{{ $sale->land?->land_name ?? $sale->land?->land_code ?? 'N/A' }}"

                                        @selected(old('land_share_sale_id') == $sale->id)>

                                    {{ $sale->sale_code ?? 'Sale #'.$sale->id }}
                                    —
                                    {{ $sale->client?->name ?? 'N/A' }}
                                    —
                                    ৳{{ number_format($price, 2) }}
                                    — Paid ৳{{ number_format($paid, 2) }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                    <p class="mt-1 text-xs text-slate-500">
                        Only fully paid land share sales are available for registration.
                    </p>

                    @error('land_share_sale_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                {{-- =====================================================
                     CLIENT INFORMATION
                     No manual client_id input
                ====================================================== --}}
                <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id') }}">
                <div class="md:col-span-2 lg:col-span-3">

                    <div id="clientInformation"
                         class="hidden rounded-xl border border-blue-200 bg-blue-50 p-5">

                        <div class="mb-4 flex items-center gap-2">
                            <i class="bi bi-person-check-fill text-blue-600"></i>

                            <h3 class="font-semibold text-slate-800">
                                Client Information
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                            {{-- Client Name --}}
                            <div class="rounded-lg border border-blue-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Client Name
                                </p>

                                <p id="client_name"
                                   class="mt-1 font-semibold text-slate-800">
                                    -
                                </p>

                            </div>


                            {{-- Phone --}}
                            <div class="rounded-lg border border-blue-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Phone
                                </p>

                                <p id="client_phone"
                                   class="mt-1 font-semibold text-slate-800">
                                    -
                                </p>

                            </div>


                            {{-- Email --}}
                            <div class="rounded-lg border border-blue-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Email
                                </p>

                                <p id="client_email"
                                   class="mt-1 font-semibold text-slate-800">
                                    -
                                </p>

                            </div>

                        </div>

                        <p class="mt-3 text-xs text-blue-700">
                            Client information is automatically taken from the selected land share sale.
                        </p>

                    </div>

                </div>


                {{-- =====================================================
                     SALE PAYMENT INFORMATION
                ====================================================== --}}
                <div class="md:col-span-2 lg:col-span-3">

                    <div id="salePaymentInformation"
                         class="hidden rounded-xl border border-emerald-200 bg-emerald-50 p-5">

                        <div class="mb-4 flex items-center gap-2">

                            <i class="bi bi-cash-stack text-emerald-600"></i>

                            <h3 class="font-semibold text-slate-800">
                                Sale Payment Information
                            </h3>

                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                            {{-- Sale Price --}}
                            <div class="rounded-lg border border-emerald-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Land Share Price
                                </p>

                                <p id="sale_price"
                                   class="mt-1 text-lg font-bold text-blue-700">
                                    ৳ 0.00
                                </p>

                            </div>


                            {{-- Paid --}}
                            <div class="rounded-lg border border-emerald-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Total Paid
                                </p>

                                <p id="sale_paid"
                                   class="mt-1 text-lg font-bold text-emerald-700">
                                    ৳ 0.00
                                </p>

                            </div>


                            {{-- Due --}}
                            <div class="rounded-lg border border-emerald-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Remaining Due
                                </p>

                                <p id="sale_due"
                                   class="mt-1 text-lg font-bold text-amber-700">
                                    ৳ 0.00
                                </p>

                            </div>


                            {{-- Percentage --}}
                            <div class="rounded-lg border border-emerald-100 bg-white p-4">

                                <p class="text-xs text-slate-500">
                                    Payment Percentage
                                </p>

                                <p id="sale_percentage"
                                   class="mt-1 text-lg font-bold text-emerald-700">
                                    0%
                                </p>

                            </div>

                        </div>


                        {{-- Payment Status --}}
                        <div class="mt-4 rounded-lg border border-emerald-200 bg-white p-4">

                            <div class="flex items-center justify-between gap-3">

                                <div>
                                    <p class="text-xs text-slate-500">
                                        Payment Status
                                    </p>

                                    <p id="payment_status"
                                       class="mt-1 font-bold text-emerald-700">
                                        Fully Paid
                                    </p>
                                </div>

                                <span id="payment_status_badge"
                                      class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">

                                    <i class="bi bi-check-circle-fill"></i>
                                    Fully Paid

                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="pending"
                            @selected(old('status', 'pending') === 'pending')>
                            Pending
                        </option>

                        <option value="processing"
                            @selected(old('status') === 'processing')>
                            Processing
                        </option>

                        <option value="completed"
                            @selected(old('status') === 'completed')>
                            Completed
                        </option>

                        <option value="cancelled"
                            @selected(old('status') === 'cancelled')>
                            Cancelled
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>
        </div>


        {{-- =========================================================
             REGISTRATION DETAILS
        ========================================================== --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Registration Details
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">

                {{-- Deed No --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Deed No
                    </label>

                    <input type="text"
                           name="deed_no"
                           value="{{ old('deed_no') }}"
                           placeholder="Enter deed number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Registration Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Date
                    </label>

                    <input type="date"
                           name="registration_date"
                           value="{{ old('registration_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Sub Registry --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Sub Registry Office
                    </label>

                    <input type="text"
                           name="sub_registry_office"
                           value="{{ old('sub_registry_office') }}"
                           placeholder="Sub registry office"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- District --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        District
                    </label>

                    <input type="text"
                           name="district"
                           value="{{ old('district') }}"
                           placeholder="District"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Upazila --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Upazila
                    </label>

                    <input type="text"
                           name="upazila"
                           value="{{ old('upazila') }}"
                           placeholder="Upazila"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Mouza --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Mouza
                    </label>

                    <input type="text"
                           name="mouza"
                           value="{{ old('mouza') }}"
                           placeholder="Mouza"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Khatian --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Khatian No
                    </label>

                    <input type="text"
                           name="khatian_no"
                           value="{{ old('khatian_no') }}"
                           placeholder="Khatian number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Dag --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Dag No
                    </label>

                    <input type="text"
                           name="dag_no"
                           value="{{ old('dag_no') }}"
                           placeholder="Dag number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- JL --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        JL No
                    </label>

                    <input type="text"
                           name="jl_no"
                           value="{{ old('jl_no') }}"
                           placeholder="JL number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Registered Land Size --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registered Land Size
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="registered_land_size"
                           value="{{ old('registered_land_size') }}"
                           placeholder="0.00"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>


                {{-- Land Unit --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Unit <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="land_unit"
                           value="{{ old('land_unit', 'Decimal') }}"
                           required
                           placeholder="Decimal / Katha / Bigha"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

            </div>
        </div>


        {{-- =========================================================
             COSTS
        ========================================================== --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Registration Cost
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Registration Cost --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Cost
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="registration_cost"
                           value="{{ old('registration_cost', 0) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                </div>


                {{-- Other Cost --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Other Cost
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="other_cost"
                           value="{{ old('other_cost', 0) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                </div>


                {{-- Total --}}
                <div class="rounded-lg bg-slate-50 p-4">

                    <p class="text-sm text-slate-500">
                        Total Cost
                    </p>

                    <p id="total_cost_preview"
                       class="mt-1 text-xl font-bold text-slate-800">
                        ৳ 0.00
                    </p>

                </div>

            </div>
        </div>


        {{-- =========================================================
             DOCUMENTS
        ========================================================== --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Documents
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Deed Document --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Deed Document
                    </label>

                    <input type="file"
                           name="deed_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        PDF, JPG, JPEG, PNG — Max 5MB
                    </p>

                </div>


                {{-- Registration Document --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Document
                    </label>

                    <input type="file"
                           name="registration_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        PDF, JPG, JPEG, PNG — Max 5MB
                    </p>

                </div>


                {{-- Other Document --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Other Document
                    </label>

                    <input type="file"
                           name="other_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        PDF, JPG, JPEG, PNG — Max 5MB
                    </p>

                </div>

            </div>
        </div>


        {{-- =========================================================
             REMARKS
        ========================================================== --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="p-5">

                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Remarks
                </label>

                <textarea name="remarks"
                          rows="4"
                          placeholder="Additional notes..."
                          class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('remarks') }}</textarea>

            </div>

        </div>


        {{-- =========================================================
             ACTIONS
        ========================================================== --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-registrations.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    id="submitBtn"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">

                <i class="bi bi-check-lg mr-1"></i>

                Save Registration

            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');
    const saleSelect = document.getElementById('land_share_sale_id');

    const clientInformation =
        document.getElementById('clientInformation');

    const clientIdInput =
        document.getElementById('client_id');

    const salePaymentInformation =
        document.getElementById('salePaymentInformation');

    const clientName =
        document.getElementById('client_name');

    const clientPhone =
        document.getElementById('client_phone');

    const clientEmail =
        document.getElementById('client_email');

    const salePrice =
        document.getElementById('sale_price');

    const salePaid =
        document.getElementById('sale_paid');

    const saleDue =
        document.getElementById('sale_due');

    const salePercentage =
        document.getElementById('sale_percentage');

    const paymentStatus =
        document.getElementById('payment_status');

    const paymentStatusBadge =
        document.getElementById('payment_status_badge');

    const registrationCost =
        document.querySelector('[name="registration_cost"]');

    const otherCost =
        document.querySelector('[name="other_cost"]');

    const totalPreview =
        document.getElementById('total_cost_preview');


    /* =========================================================
       FORMAT MONEY
    ========================================================== */

    function formatMoney(value) {

        return Number(value || 0).toLocaleString('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

    }


    /* =========================================================
       COMPANY → BRANCH
    ========================================================== */

    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const companyMatch =
                !companyId ||
                option.dataset.company === companyId;

            option.hidden = !companyMatch;

        });


        const selectedOption =
            branchSelect.options[branchSelect.selectedIndex];

        if (
            branchSelect.value &&
            selectedOption &&
            selectedOption.hidden
        ) {
            branchSelect.value = '';
        }

    }


    /* =========================================================
       COMPANY + BRANCH → PROJECT
    ========================================================== */

    function filterProjects() {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const companyMatch =
                !companyId ||
                option.dataset.company === companyId;

            const branchMatch =
                !branchId ||
                option.dataset.branch === branchId;

            option.hidden =
                !(companyMatch && branchMatch);

        });


        const selectedOption =
            projectSelect.options[projectSelect.selectedIndex];

        if (
            projectSelect.value &&
            selectedOption &&
            selectedOption.hidden
        ) {
            projectSelect.value = '';
        }

    }


    /* =========================================================
       COMPANY + BRANCH + PROJECT → SALE
    ========================================================== */

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
                !companyId ||
                option.dataset.company === companyId;

            const branchMatch =
                !branchId ||
                option.dataset.branch === branchId;

            const projectMatch =
                !projectId ||
                option.dataset.project === projectId;

            option.hidden =
                !(companyMatch &&
                  branchMatch &&
                  projectMatch);

        });


        const selectedOption =
            saleSelect.options[saleSelect.selectedIndex];

        if (
            saleSelect.value &&
            selectedOption &&
            selectedOption.hidden
        ) {
            saleSelect.value = '';
        }

        updateSaleInformation();

    }


    /* =========================================================
       SALE INFORMATION
    ========================================================== */

    function updateSaleInformation() {

        const option =
            saleSelect.options[saleSelect.selectedIndex];


        if (
            !saleSelect.value ||
            !option ||
            option.hidden
        ) {
            clientIdInput.value = '';
            clientInformation.classList.add('hidden');
            salePaymentInformation.classList.add('hidden');
            return;
        }
        /*  CLIENT  */
        const clientId = option.dataset.clientId || '';

        clientIdInput.value = clientId;
        clientName.textContent = option.dataset.client || 'N/A';

        clientPhone.textContent =
            option.dataset.phone || 'N/A';

        clientEmail.textContent =
            option.dataset.email || 'N/A';

        clientInformation.classList.remove('hidden');


        /* -------------------------
           PAYMENT
        ------------------------- */

        const price =
            parseFloat(option.dataset.price || 0);

        const paid =
            parseFloat(option.dataset.paid || 0);

        const due =
            parseFloat(option.dataset.due || 0);

        const percentage =
            parseFloat(option.dataset.percentage || 0);


        salePrice.textContent =
            '৳ ' + formatMoney(price);

        salePaid.textContent =
            '৳ ' + formatMoney(paid);

        saleDue.textContent =
            '৳ ' + formatMoney(due);

        salePercentage.textContent =
            percentage.toFixed(2) + '%';


        /* -------------------------
           STATUS
        ------------------------- */

        if (due <= 0.01) {

            paymentStatus.textContent =
                'Fully Paid';

            paymentStatus.className =
                'mt-1 font-bold text-emerald-700';

            paymentStatusBadge.className =
                'inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700';

            paymentStatusBadge.innerHTML =
                '<i class="bi bi-check-circle-fill"></i> Fully Paid';

        } else {

            paymentStatus.textContent =
                'Payment Due';

            paymentStatus.className =
                'mt-1 font-bold text-amber-700';

            paymentStatusBadge.className =
                'inline-flex items-center gap-1 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700';

            paymentStatusBadge.innerHTML =
                '<i class="bi bi-exclamation-circle-fill"></i> Payment Due';

        }


        salePaymentInformation.classList.remove('hidden');

    }


    /* =========================================================
       TOTAL REGISTRATION COST
    ========================================================== */

    function updateTotal() {

        const registration =
            parseFloat(registrationCost.value) || 0;

        const other =
            parseFloat(otherCost.value) || 0;

        const total =
            registration + other;


        totalPreview.textContent =
            '৳ ' + formatMoney(total);

    }


    /* =========================================================
       EVENTS
    ========================================================== */

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


    saleSelect.addEventListener(
        'change',
        updateSaleInformation
    );


    registrationCost.addEventListener(
        'input',
        updateTotal
    );


    otherCost.addEventListener(
        'input',
        updateTotal
    );


    /* =========================================================
       INITIAL LOAD
    ========================================================== */

    filterBranches();
    filterProjects();
    filterSales();

    updateSaleInformation();

    updateTotal();

});
</script>

@endsection 
