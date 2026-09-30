@extends('admin.layouts.app')

@section('title', 'Edit Land Registration')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit Land Registration
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                {{ $landRegistration->registration_code }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.land-registrations.show', $landRegistration) }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-eye"></i>
                View
            </a>

            <a href="{{ route('admin.land-registrations.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

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

    <form action="{{ route('admin.land-registrations.update', $landRegistration) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')

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
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                @selected(old('company_id', $landRegistration->company_id) == $company->id)>
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
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                @selected(old('branch_id', $landRegistration->branch_id) == $branch->id)>
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
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                @selected(old('project_id', $landRegistration->project_id) == $project->id)>
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
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Land Share Sale</option>

                        @foreach($sales as $sale)

                            @php
                                $paid = (float) $sale->payments->sum('amount');
                                $price = (float) $sale->land_share_price;
                            @endphp

                            <option value="{{ $sale->id }}"
                                @selected(old('land_share_sale_id', $landRegistration->land_share_sale_id) == $sale->id)>

                                Sale #{{ $sale->id }}
                                —
                                {{ $sale->client?->name ?? 'N/A' }}
                                —
                                ৳{{ number_format($price, 2) }}
                                — Paid ৳{{ number_format($paid, 2) }}

                            </option>

                        @endforeach

                    </select>

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
                           value="{{ old('client_id', $landRegistration->client_id) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('client_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        @foreach([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled'
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                @selected(old('status', $landRegistration->status) === $value)>
                                {{ $label }}
                            </option>

                        @endforeach

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

                @foreach([
                    'deed_no' => 'Deed No',
                    'sub_registry_office' => 'Sub Registry Office',
                    'district' => 'District',
                    'upazila' => 'Upazila',
                    'mouza' => 'Mouza',
                    'khatian_no' => 'Khatian No',
                    'dag_no' => 'Dag No',
                    'jl_no' => 'JL No',
                ] as $field => $label)

                    <div>

                        <label class="mb-1.5 block text-sm font-medium text-slate-700">
                            {{ $label }}
                        </label>

                        <input type="text"
                               name="{{ $field }}"
                               value="{{ old($field, $landRegistration->{$field}) }}"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        @error($field)
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                @endforeach

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Date
                    </label>

                    <input type="date"
                           name="registration_date"
                           value="{{ old('registration_date', $landRegistration->registration_date ? \Carbon\Carbon::parse($landRegistration->registration_date)->format('Y-m-d') : '') }}"
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
                           value="{{ old('registered_land_size', $landRegistration->registered_land_size) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Unit <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="land_unit"
                           value="{{ old('land_unit', $landRegistration->land_unit) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

            </div>
        </div>

        {{-- Cost --}}
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
                           value="{{ old('registration_cost', $landRegistration->registration_cost ?? 0) }}"
                           class="registration-cost w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Other Cost
                    </label>

                    <input type="number"
                           step="0.01"
                           min="0"
                           name="other_cost"
                           value="{{ old('other_cost', $landRegistration->other_cost ?? 0) }}"
                           class="other-cost w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                </div>

                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">
                        Total Cost
                    </p>

                    <p id="total_cost_preview"
                       class="mt-1 text-xl font-bold text-slate-800">
                        ৳ {{ number_format((float) $landRegistration->total_cost, 2) }}
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

                {{-- Deed --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Deed Document
                    </label>

                    @if($landRegistration->deed_document)

                        <div class="mb-3 flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2">

                            <span class="truncate text-xs text-slate-600">
                                Existing document
                            </span>

                            <a href="{{ asset('storage/' . $landRegistration->deed_document) }}"
                               target="_blank"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                View
                            </a>

                        </div>

                    @endif

                    <input type="file"
                           name="deed_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        Leave empty to keep existing document.
                    </p>

                </div>

                {{-- Registration --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Registration Document
                    </label>

                    @if($landRegistration->registration_document)

                        <div class="mb-3 flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2">

                            <span class="truncate text-xs text-slate-600">
                                Existing document
                            </span>

                            <a href="{{ asset('storage/' . $landRegistration->registration_document) }}"
                               target="_blank"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                View
                            </a>

                        </div>

                    @endif

                    <input type="file"
                           name="registration_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        Leave empty to keep existing document.
                    </p>

                </div>

                {{-- Other --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Other Document
                    </label>

                    @if($landRegistration->other_document)

                        <div class="mb-3 flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2">

                            <span class="truncate text-xs text-slate-600">
                                Existing document
                            </span>

                            <a href="{{ asset('storage/' . $landRegistration->other_document) }}"
                               target="_blank"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-700">
                                View
                            </a>

                        </div>

                    @endif

                    <input type="file"
                           name="other_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        Leave empty to keep existing document.
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
                          class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('remarks', $landRegistration->remarks) }}</textarea>

            </div>

        </div>

        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-registrations.show', $landRegistration) }}"
               class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg mr-1"></i>
                Update Registration
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