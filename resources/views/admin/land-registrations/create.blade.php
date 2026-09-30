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

    <form action="{{ route('admin.land-registrations.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf

        {{-- Basic Information --}}
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

                    <select name="company_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
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

                    <select name="branch_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
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

                    <select name="project_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                @selected(old('project_id') == $project->id)>
                                {{ $project->project_name }}
                            </option>
                        @endforeach

                    </select>

                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Sale --}}
                <div class="md:col-span-2 lg:col-span-3">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Share Sale <span class="text-red-500">*</span>
                    </label>

                    <select name="land_share_sale_id"
                            id="land_share_sale_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Select Fully Paid Land Share Sale
                        </option>

                        @foreach($sales as $sale)

                            @php
                                $paid = (float) $sale->payments->sum('amount');
                                $price = (float) $sale->land_share_price;
                            @endphp

                            <option value="{{ $sale->id }}"
                                @selected(old('land_share_sale_id') == $sale->id)>

                                Sale #{{ $sale->id }}
                                —
                                {{ $sale->client?->name ?? 'N/A' }}
                                —
                                ৳{{ number_format($price, 2) }}
                                — Paid ৳{{ number_format($paid, 2) }}

                            </option>

                        @endforeach

                    </select>

                    <p class="mt-1 text-xs text-slate-500">
                        Only confirmed/completed sales with 100% land share payment are available.
                    </p>

                    @error('land_share_sale_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Client --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Client ID <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           name="client_id"
                           value="{{ old('client_id') }}"
                           required
                           placeholder="Enter client ID"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    @error('client_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <p class="mt-1 text-xs text-slate-500">
                        Client must belong to the selected land share sale.
                    </p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="pending" @selected(old('status', 'pending') === 'pending')>
                            Pending
                        </option>

                        <option value="processing" @selected(old('status') === 'processing')>
                            Processing
                        </option>

                        <option value="completed" @selected(old('status') === 'completed')>
                            Completed
                        </option>

                        <option value="cancelled" @selected(old('status') === 'cancelled')>
                            Cancelled
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Registration Details --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Registration Details
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">

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

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Date
                    </label>

                    <input type="date"
                           name="registration_date"
                           value="{{ old('registration_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

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

        {{-- Costs --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Registration Cost
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

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

        {{-- Documents --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Documents
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

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

        {{-- Remarks --}}
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

        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-registrations.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg mr-1"></i>
                Save Registration
            </button>

        </div>

    </form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const registrationCost = document.querySelector('[name="registration_cost"]');
        const otherCost = document.querySelector('[name="other_cost"]');
        const totalPreview = document.getElementById('total_cost_preview');

        function updateTotal() {
            const registration = parseFloat(registrationCost.value) || 0;
            const other = parseFloat(otherCost.value) || 0;

            const total = registration + other;

            totalPreview.textContent =
                '৳ ' + total.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
        }

        registrationCost.addEventListener('input', updateTotal);
        otherCost.addEventListener('input', updateTotal);

        updateTotal();
    });
</script>

@endsection