@extends('admin.layouts.app')

@section('title', 'Edit Land')
@section('page-title', 'Edit Land')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit Land
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update land information for {{ $land->land_code }}.
            </p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row">

            <a href="{{ route('admin.lands.show', $land) }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                <i class="bi bi-eye"></i>
                View Land
            </a>

            <a href="{{ route('admin.lands.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>


    <form action="{{ route('admin.lands.update', $land) }}"
          method="POST"
          class="space-y-6">

        @csrf
        @method('PUT')


        {{-- Business Assignment --}}
        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                    <i class="bi bi-diagram-3 text-blue-600"></i>
                    Business Assignment
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Select the company, branch and project for this land.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Company --}}
                <div>

                    <label for="company_id"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="company_id"
                        id="company_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">Select Company</option>

                        @foreach($companies as $company)

                            <option
                                value="{{ $company->id }}"
                                {{ old('company_id', $land->company_id) == $company->id ? 'selected' : '' }}
                            >
                                {{ $company->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('company_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Branch --}}
                <div>

                    <label for="branch_id"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="branch_id"
                        id="branch_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                                data-company="{{ $branch->company_id }}"
                                {{ old('branch_id', $land->branch_id) == $branch->id ? 'selected' : '' }}
                            >
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('branch_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Project --}}
                <div>

                    <label for="project_id"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="project_id"
                        id="project_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">Select Project</option>

                        @foreach($projects as $project)

                            <option
                                value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ old('project_id', $land->project_id) == $project->id ? 'selected' : '' }}
                            >
                                {{ $project->project_name }}

                                @if($project->project_code)
                                    ({{ $project->project_code }})
                                @endif
                            </option>

                        @endforeach

                    </select>

                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Land Identification --}}
        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                    <i class="bi bi-map text-blue-600"></i>
                    Land Identification
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Land Code --}}
                <div>

                    <label for="land_code"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Code <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="land_code"
                        id="land_code"
                        value="{{ old('land_code', $land->land_code) }}"
                        required
                        maxlength="100"
                        placeholder="e.g. LAND-001"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('land_code')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Land Name --}}
                <div>

                    <label for="land_name"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Name
                    </label>

                    <input
                        type="text"
                        name="land_name"
                        id="land_name"
                        value="{{ old('land_name', $land->land_name) }}"
                        maxlength="255"
                        placeholder="Land name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('land_name')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Location & Records --}}
        <div class="erp-card">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                    <i class="bi bi-geo-alt text-blue-600"></i>
                    Land Location & Records
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- District --}}
                <div>

                    <label for="district"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        District
                    </label>

                    <input
                        type="text"
                        name="district"
                        id="district"
                        value="{{ old('district', $land->district) }}"
                        maxlength="100"
                        placeholder="District"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('district')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Upazila --}}
                <div>

                    <label for="upazila"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Upazila
                    </label>

                    <input
                        type="text"
                        name="upazila"
                        id="upazila"
                        value="{{ old('upazila', $land->upazila) }}"
                        maxlength="100"
                        placeholder="Upazila"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('upazila')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Mouza --}}
                <div>

                    <label for="mouza"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Mouza
                    </label>

                    <input
                        type="text"
                        name="mouza"
                        id="mouza"
                        value="{{ old('mouza', $land->mouza) }}"
                        maxlength="150"
                        placeholder="Mouza"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('mouza')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Khatian --}}
                <div>

                    <label for="khatian_no"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Khatian No.
                    </label>

                    <input
                        type="text"
                        name="khatian_no"
                        id="khatian_no"
                        value="{{ old('khatian_no', $land->khatian_no) }}"
                        maxlength="100"
                        placeholder="Khatian number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('khatian_no')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Dag --}}
                <div>

                    <label for="dag_no"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Dag No.
                    </label>

                    <input
                        type="text"
                        name="dag_no"
                        id="dag_no"
                        value="{{ old('dag_no', $land->dag_no) }}"
                        maxlength="100"
                        placeholder="Dag number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('dag_no')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- JL --}}
                <div>

                    <label for="jl_no"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        JL No.
                    </label>

                    <input
                        type="text"
                        name="jl_no"
                        id="jl_no"
                        value="{{ old('jl_no', $land->jl_no) }}"
                        maxlength="100"
                        placeholder="JL number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('jl_no')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

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


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2">

                {{-- Size --}}
                <div>

                    <label for="total_land_size"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Total Land Size
                    </label>

                    <input
                        type="number"
                        name="total_land_size"
                        id="total_land_size"
                        value="{{ old('total_land_size', $land->total_land_size) }}"
                        min="0"
                        step="0.0001"
                        placeholder="0.0000"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('total_land_size')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Unit --}}
                <div>

                    <label for="land_unit"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Unit <span class="text-red-500">*</span>
                    </label>

                    @php
                        $units = [
                            'decimal' => 'Decimal',
                            'katha' => 'Katha',
                            'bigha' => 'Bigha',
                            'acre' => 'Acre',
                            'sqft' => 'Square Feet',
                        ];
                    @endphp

                    <select
                        name="land_unit"
                        id="land_unit"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        @foreach($units as $value => $label)

                            <option
                                value="{{ $value }}"
                                {{ old('land_unit', $land->land_unit) === $value ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                    @error('land_unit')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

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


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Owner Name --}}
                <div>

                    <label for="owner_name"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Owner Name
                    </label>

                    <input
                        type="text"
                        name="owner_name"
                        id="owner_name"
                        value="{{ old('owner_name', $land->owner_name) }}"
                        maxlength="255"
                        placeholder="Land owner name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('owner_name')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Phone --}}
                <div>

                    <label for="owner_phone"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Owner Phone
                    </label>

                    <input
                        type="text"
                        name="owner_phone"
                        id="owner_phone"
                        value="{{ old('owner_phone', $land->owner_phone) }}"
                        maxlength="30"
                        placeholder="01XXXXXXXXX"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('owner_phone')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NID --}}
                <div>

                    <label for="owner_nid"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Owner NID
                    </label>

                    <input
                        type="text"
                        name="owner_nid"
                        id="owner_nid"
                        value="{{ old('owner_nid', $land->owner_nid) }}"
                        maxlength="50"
                        placeholder="NID number"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('owner_nid')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

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


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Purchase Price --}}
                <div>

                    <label for="purchase_price"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Purchase Price <span class="text-red-500">*</span>
                    </label>

                    <div class="relative">

                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                            ৳
                        </span>

                        <input
                            type="number"
                            name="purchase_price"
                            id="purchase_price"
                            value="{{ old('purchase_price', $land->purchase_price) }}"
                            required
                            min="0"
                            step="0.01"
                            class="w-full rounded-lg border border-slate-300 py-2.5 pl-8 pr-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                    </div>

                    @error('purchase_price')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Purchase Date --}}
                <div>

                    <label for="purchase_date"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Purchase Date
                    </label>

                    <input
                        type="date"
                        name="purchase_date"
                        id="purchase_date"
                        value="{{ old('purchase_date', optional($land->purchase_date)->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('purchase_date')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Status --}}
                <div>

                    <label for="status"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="status"
                        id="status"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="available"
                            {{ old('status', $land->status) === 'available' ? 'selected' : '' }}>
                            Available
                        </option>

                        <option value="partially_sold"
                            {{ old('status', $land->status) === 'partially_sold' ? 'selected' : '' }}>
                            Partially Sold
                        </option>

                        <option value="fully_sold"
                            {{ old('status', $land->status) === 'fully_sold' ? 'selected' : '' }}>
                            Fully Sold
                        </option>

                        <option value="registered"
                            {{ old('status', $land->status) === 'registered' ? 'selected' : '' }}>
                            Registered
                        </option>

                        <option value="closed"
                            {{ old('status', $land->status) === 'closed' ? 'selected' : '' }}>
                            Closed
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

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

                {{-- Description --}}
                <div>

                    <label for="description"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        placeholder="Enter land description..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >{{ old('description', $land->description) }}</textarea>

                    @error('description')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Remarks --}}
                <div>

                    <label for="remarks"
                           class="mb-1.5 block text-sm font-medium text-slate-700">
                        Remarks
                    </label>

                    <textarea
                        name="remarks"
                        id="remarks"
                        rows="3"
                        placeholder="Enter any additional remarks..."
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >{{ old('remarks', $land->remarks) }}</textarea>

                    @error('remarks')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.lands.show', $land) }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
            >
                <i class="bi bi-check-lg"></i>
                Update Land
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


    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = companyId &&
                option.dataset.company !== companyId;

        });

        if (
            branchSelect.value &&
            companyId &&
            branchSelect.selectedOptions[0]?.dataset.company !== companyId
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

            const optionCompany = option.dataset.company;
            const optionBranch = option.dataset.branch;

            let visible = true;

            if (companyId && optionCompany !== companyId) {
                visible = false;
            }

            if (branchId && optionBranch !== branchId) {
                visible = false;
            }

            option.hidden = !visible;

        });


        if (
            projectSelect.value &&
            projectSelect.selectedOptions[0]?.hidden
        ) {
            projectSelect.value = '';
        }

    }


    companySelect.addEventListener('change', function () {

        filterBranches();
        filterProjects();

    });


    branchSelect.addEventListener('change', function () {

        filterProjects();

    });


    filterBranches();
    filterProjects();

});
</script>

@endpush 
