@extends('admin.layouts.app')

@section('title', 'Land Management')
@section('page-title', 'Land Management')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Land Management
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage project-wise and branch-wise land information.
            </p>
        </div>

        <a href="{{ route('admin.lands.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <i class="bi bi-plus-lg"></i>
            Add Land
        </a>
    </div>


    {{-- Search & Filters --}}
    <div class="erp-card p-4 sm:p-5">

        <form method="GET"
              action="{{ route('admin.lands.index') }}"
              class="space-y-4">

            {{-- Search --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Search
                </label>

                <div class="relative">
                    <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Land code, land name, mouza, khatian, dag or owner..."
                        class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </div>
            </div>


            {{-- Filters --}}
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">

                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company
                    </label>

                    <select
                        name="company_id"
                        id="company_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">All Companies</option>

                        @foreach($companies as $company)
                            <option
                                value="{{ $company->id }}"
                                {{ (string) request('company_id') === (string) $company->id ? 'selected' : '' }}
                            >
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Branch --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Branch
                    </label>

                    <select
                        name="branch_id"
                        id="branch_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">All Branches</option>

                        @foreach($branches as $branch)
                            <option
                                value="{{ $branch->id }}"
                                data-company="{{ $branch->company_id }}"
                                {{ (string) request('branch_id') === (string) $branch->id ? 'selected' : '' }}
                            >
                                {{ $branch->name }}
                                @if($branch->company)
                                    — {{ $branch->company->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Project --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project
                    </label>

                    <select
                        name="project_id"
                        id="project_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">All Projects</option>

                        @foreach($projects as $project)
                            <option
                                value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ (string) request('project_id') === (string) $project->id ? 'selected' : '' }}
                            >
                                {{ $project->project_name }}
                                @if($project->project_code)
                                    ({{ $project->project_code }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                        <option value="">All Status</option>

                        <option value="available"
                            {{ request('status') === 'available' ? 'selected' : '' }}>
                            Available
                        </option>

                        <option value="partially_sold"
                            {{ request('status') === 'partially_sold' ? 'selected' : '' }}>
                            Partially Sold
                        </option>

                        <option value="fully_sold"
                            {{ request('status') === 'fully_sold' ? 'selected' : '' }}>
                            Fully Sold
                        </option>

                        <option value="registered"
                            {{ request('status') === 'registered' ? 'selected' : '' }}>
                            Registered
                        </option>

                        <option value="closed"
                            {{ request('status') === 'closed' ? 'selected' : '' }}>
                            Closed
                        </option>
                    </select>
                </div>

            </div>


            {{-- Filter Buttons --}}
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-900"
                >
                    <i class="bi bi-funnel"></i>
                    Apply Filters
                </button>

                <a
                    href="{{ route('admin.lands.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>

            </div>

        </form>
    </div>


    {{-- Land Table --}}
    <div class="erp-card overflow-hidden">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-200 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-5">

            <div>
                <h2 class="text-lg font-semibold text-slate-800">
                    Land List
                </h2>

                <p class="text-sm text-slate-500">
                    Total {{ $lands->total() }} land record{{ $lands->total() != 1 ? 's' : '' }}
                </p>
            </div>

        </div>


        @if($lands->count())

            <div class="table-responsive">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                        <tr>
                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Land
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Company / Branch
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Project
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Location
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Size
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Purchase Price
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Owner
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 font-semibold">
                                Status
                            </th>

                            <th class="whitespace-nowrap px-4 py-3 text-right font-semibold">
                                Actions
                            </th>
                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach($lands as $land)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Land --}}
                                <td class="px-4 py-4 align-top">

                                    <div class="font-semibold text-slate-800">
                                        {{ $land->land_code }}
                                    </div>

                                    @if($land->land_name)
                                        <div class="mt-0.5 text-xs text-slate-500">
                                            {{ $land->land_name }}
                                        </div>
                                    @endif

                                    @if($land->khatian_no || $land->dag_no)

                                        <div class="mt-2 flex flex-wrap gap-1">

                                            @if($land->khatian_no)
                                                <span class="rounded bg-blue-50 px-2 py-1 text-xs text-blue-700">
                                                    Khatian: {{ $land->khatian_no }}
                                                </span>
                                            @endif

                                            @if($land->dag_no)
                                                <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-600">
                                                    Dag: {{ $land->dag_no }}
                                                </span>
                                            @endif

                                        </div>

                                    @endif

                                </td>


                                {{-- Company / Branch --}}
                                <td class="px-4 py-4 align-top">

                                    <div class="font-medium text-slate-700">
                                        {{ $land->company?->name ?? '—' }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $land->branch?->name ?? '—' }}
                                    </div>

                                </td>


                                {{-- Project --}}
                                <td class="px-4 py-4 align-top">

                                    @if($land->project)

                                        <div class="font-medium text-slate-700">
                                            {{ $land->project->project_name }}
                                        </div>

                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $land->project->project_code }}
                                        </div>

                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif

                                </td>


                                {{-- Location --}}
                                <td class="px-4 py-4 align-top">

                                    @if($land->mouza)
                                        <div class="font-medium text-slate-700">
                                            {{ $land->mouza }}
                                        </div>
                                    @endif

                                    @if($land->district || $land->upazila)

                                        <div class="mt-1 text-xs text-slate-500">

                                            @if($land->upazila)
                                                {{ $land->upazila }}
                                            @endif

                                            @if($land->district)
                                                @if($land->upazila)
                                                    ,
                                                @endif
                                                {{ $land->district }}
                                            @endif

                                        </div>

                                    @endif

                                    @if(!$land->mouza && !$land->district && !$land->upazila)
                                        <span class="text-slate-400">—</span>
                                    @endif

                                </td>


                                {{-- Size --}}
                                <td class="px-4 py-4 align-top">

                                    @if($land->total_land_size !== null)

                                        <span class="font-semibold text-slate-700">
                                            {{ number_format((float) $land->total_land_size, 4) }}
                                        </span>

                                        <span class="text-xs text-slate-500">
                                            {{ $land->land_unit }}
                                        </span>

                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif

                                </td>


                                {{-- Purchase Price --}}
                                <td class="px-4 py-4 align-top whitespace-nowrap">

                                    <span class="font-semibold text-slate-700">
                                        ৳ {{ number_format((float) $land->purchase_price, 2) }}
                                    </span>

                                    @if($land->purchase_date)

                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $land->purchase_date->format('d M Y') }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Owner --}}
                                <td class="px-4 py-4 align-top">

                                    @if($land->owner_name)

                                        <div class="font-medium text-slate-700">
                                            {{ $land->owner_name }}
                                        </div>

                                        @if($land->owner_phone)
                                            <div class="mt-1 text-xs text-slate-500">
                                                {{ $land->owner_phone }}
                                            </div>
                                        @endif

                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-4 py-4 align-top">

                                    @php
                                        $statusClasses = match($land->status) {
                                            'available' => 'bg-green-50 text-green-700 border-green-200',
                                            'partially_sold' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'fully_sold' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'registered' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                            'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            default => 'bg-slate-100 text-slate-600 border-slate-200',
                                        };

                                        $statusLabel = match($land->status) {
                                            'available' => 'Available',
                                            'partially_sold' => 'Partially Sold',
                                            'fully_sold' => 'Fully Sold',
                                            'registered' => 'Registered',
                                            'closed' => 'Closed',
                                            default => ucfirst(str_replace('_', ' ', $land->status)),
                                        };
                                    @endphp

                                    <span class="inline-flex whitespace-nowrap rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                        {{ $statusLabel }}
                                    </span>

                                </td>


                                {{-- Actions --}}
                                <td class="px-4 py-4 align-top">

                                    <div class="flex items-center justify-end gap-1">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('admin.lands.show', $land) }}"
                                            title="View"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-blue-600 transition hover:bg-blue-50"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('admin.lands.edit', $land) }}"
                                            title="Edit"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-amber-600 transition hover:bg-amber-50"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.lands.destroy', $land) }}" method="POST" class="delete-land-form inline">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Delete"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-600 transition hover:bg-red-50"
                                            >
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            @if($lands->hasPages())

                <div class="border-t border-slate-200 px-4 py-4 sm:px-5">
                    {{ $lands->links() }}
                </div>

            @endif
        @else

            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
                    <i class="bi bi-map text-2xl text-slate-400"></i>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-800">
                    No land records found
                </h3>
                <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                    No land records match your current search or filters.
                </p>
                <a  href="{{ route('admin.lands.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    <i class="bi bi-plus-lg"></i>
                    Add Land
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');

    const selectedBranch = "{{ request('branch_id') }}";
    const selectedProject = "{{ request('project_id') }}";

    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {
            if (!option.value) {
                option.hidden = false;
                return;
            }
            const optionCompany = option.dataset.company;
            option.hidden = companyId && optionCompany !== companyId;
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
    // Delete Confirmation
    document.querySelectorAll('.delete-land-form').forEach(form => {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            const submitForm = this;

            if (typeof Swal !== 'undefined') {

                Swal.fire({
                    title: 'Delete Land?',
                    text: 'This land record will be permanently deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {

                    if (result.isConfirmed) {
                        submitForm.submit();
                    }

                });

            } else {

                if (confirm('Are you sure you want to delete this land record?')) {
                    submitForm.submit();
                }

            }

        });

    });

});
</script>

@endpush