@extends('admin.layouts.app')

@section('title', 'Edit Land Share Sale')
@section('page-title', 'Edit Land Share Sale')

@section('content')

<div class="mx-auto max-w-6xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Edit Land Share Sale
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ $landShareSale->sale_code }}
            </p>
        </div>

        <div class="flex gap-2">

            <a href="{{ route('admin.land-share-sales.show', $landShareSale) }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-eye"></i>
                View
            </a>

            <a href="{{ route('admin.land-share-sales.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>

    <form method="POST"
          action="{{ route('admin.land-share-sales.update', $landShareSale) }}">

        @csrf
        @method('PUT')

        {{-- Business Assignment --}}
        <div class="erp-card mb-6">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    Business Assignment
                </h2>

            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select name="company_id"
                            id="company_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id', $landShareSale->company_id) == $company->id ? 'selected' : '' }}>
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
                            id="branch_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    data-company="{{ $branch->company_id }}"
                                {{ old('branch_id', $landShareSale->branch_id) == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
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
                            id="project_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                {{ old('project_id', $landShareSale->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach

                    </select>

                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Land --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land <span class="text-red-500">*</span>
                    </label>

                    <select name="land_id"
                            id="land_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Land</option>

                        @foreach($lands as $land)
                            <option value="{{ $land->id }}"
                                    data-company="{{ $land->company_id }}"
                                    data-branch="{{ $land->branch_id }}"
                                    data-project="{{ $land->project_id }}"
                                    data-unit="{{ $land->land_unit }}"
                                    data-size="{{ $land->total_land_size }}"
                                {{ old('land_id', $landShareSale->land_id) == $land->id ? 'selected' : '' }}>
                                {{ $land->land_code }}
                                @if($land->land_name)
                                    - {{ $land->land_name }}
                                @endif
                            </option>
                        @endforeach

                    </select>

                    <p id="landInfo"
                       class="mt-2 hidden rounded-lg bg-blue-50 px-3 py-2 text-xs text-blue-700">
                    </p>

                    @error('land_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Client --}}
                <div class="md:col-span-2">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Client <span class="text-red-500">*</span>
                    </label>

                    <select name="client_id"
                            id="client_id"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">Select Client</option>

                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                    data-company="{{ $client->company_id }}"
                                    data-branch="{{ $client->branch_id }}"
                                    data-project="{{ $client->project_id }}"
                                {{ old('client_id', $landShareSale->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                                — {{ $client->phone }}
                                — {{ $client->client_code }}
                            </option>
                        @endforeach

                    </select>

                    @error('client_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>

        </div>

        {{-- Sale Information --}}
        <div class="erp-card mb-6">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    Sale Information
                </h2>

            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Sale Code --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Sale Code
                    </label>

                    <input type="text"
                           value="{{ $landShareSale->sale_code }}"
                           readonly
                           class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm">

                </div>

                {{-- Sale Date --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Sale Date <span class="text-red-500">*</span>
                    </label>

                    <input type="date"
                           name="sale_date"
                           value="{{ old('sale_date', $landShareSale->sale_date?->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('sale_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Share Size --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Share Size <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           name="share_size"
                           id="share_size"
                           value="{{ old('share_size', $landShareSale->share_size) }}"
                           step="0.0001"
                           min="0.0001"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('share_size')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Share Unit --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Share Unit
                    </label>

                    <input type="text"
                           name="share_unit"
                           id="share_unit"
                           value="{{ old('share_unit', $landShareSale->share_unit) }}"
                           readonly
                           class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm">

                </div>

                {{-- Price Per Unit --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Price Per Unit <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           name="price_per_unit"
                           id="price_per_unit"
                           value="{{ old('price_per_unit', $landShareSale->price_per_unit) }}"
                           step="0.01"
                           min="0"
                           required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('price_per_unit')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Total Price --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Share Price <span class="text-red-500">*</span>
                    </label>

                    <input type="number"
                           name="land_share_price"
                           id="land_share_price"
                           value="{{ old('land_share_price', $landShareSale->land_share_price) }}"
                           step="0.01"
                           min="0"
                           required
                           readonly
                           class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm">

                    @error('land_share_price')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Status --}}
                <div class="md:col-span-2">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        @foreach([
                            'draft' => 'Draft',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('status', $landShareSale->status) == $value ? 'selected' : '' }}>
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

        {{-- Remarks --}}
        <div class="erp-card mb-6">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Remarks
                </h2>
            </div>

            <div class="p-5">

                <textarea name="remarks"
                          rows="4"
                          class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">{{ old('remarks', $landShareSale->remarks) }}</textarea>

                @error('remarks')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror

            </div>

        </div>

        {{-- Buttons --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.land-share-sales.show', $landShareSale) }}"
               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg"></i>
                Update Sale
            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const company = document.getElementById('company_id');
    const branch = document.getElementById('branch_id');
    const project = document.getElementById('project_id');
    const land = document.getElementById('land_id');
    const client = document.getElementById('client_id');

    const shareSize = document.getElementById('share_size');
    const shareUnit = document.getElementById('share_unit');
    const pricePerUnit = document.getElementById('price_per_unit');
    const totalPrice = document.getElementById('land_share_price');
    const landInfo = document.getElementById('landInfo');

    function filterBranches() {

        const companyId = company.value;

        [...branch.options].forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                !!companyId &&
                option.dataset.company !== companyId;

        });

        if (
            branch.value &&
            companyId &&
            branch.selectedOptions[0]?.dataset.company !== companyId
        ) {
            branch.value = '';
        }

        filterProjects();
    }

    function filterProjects() {

        const companyId = company.value;
        const branchId = branch.value;

        [...project.options].forEach(option => {

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

            option.hidden = !(companyMatch && branchMatch);

        });

        filterLands();
        filterClients();
    }

    function filterLands() {

        const companyId = company.value;
        const branchId = branch.value;
        const projectId = project.value;

        [...land.options].forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const match =
                (!companyId || option.dataset.company === companyId) &&
                (!branchId || option.dataset.branch === branchId) &&
                (!projectId || option.dataset.project === projectId);

            option.hidden = !match;

        });

        updateLandInfo();
    }

    function filterClients() {

        const companyId = company.value;
        const branchId = branch.value;
        const projectId = project.value;

        [...client.options].forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const match =
                (!companyId || option.dataset.company === companyId) &&
                (!branchId || option.dataset.branch === branchId) &&
                (!projectId || option.dataset.project === projectId);

            option.hidden = !match;

        });

    }

    function updateLandInfo() {

        const option = land.selectedOptions[0];

        if (!option || !option.value) {
            landInfo.classList.add('hidden');
            return;
        }

        shareUnit.value = option.dataset.unit || '';

        landInfo.innerHTML =
            'Total Land Size: <strong>' +
            Number(option.dataset.size || 0).toFixed(4) +
            ' ' +
            (option.dataset.unit || '') +
            '</strong>';

        landInfo.classList.remove('hidden');
    }

    function calculateTotal() {

        const size = parseFloat(shareSize.value) || 0;
        const price = parseFloat(pricePerUnit.value) || 0;

        totalPrice.value = (size * price).toFixed(2);
    }

    company.addEventListener('change', filterBranches);
    branch.addEventListener('change', filterProjects);
    project.addEventListener('change', function () {
        filterLands();
        filterClients();
    });

    land.addEventListener('change', updateLandInfo);

    shareSize.addEventListener('input', calculateTotal);
    pricePerUnit.addEventListener('input', calculateTotal);

    filterBranches();
    filterProjects();
    filterLands();
    filterClients();

    updateLandInfo();
    calculateTotal();

});
</script>

@endpush