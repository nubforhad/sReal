@extends('admin.layouts.app')

@section('title', 'Land Share Sales')
@section('page-title', 'Land Share Sales')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Land Share Sales
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage land share sales and client allocations.
            </p>
        </div>

        <a href="{{ route('admin.land-share-sales.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <i class="bi bi-plus-lg"></i>
            Add Land Share Sale
        </a>
    </div>

    {{-- Filters --}}
    <div class="erp-card p-4">

        <form method="GET"
              action="{{ route('admin.land-share-sales.index') }}"
              class="space-y-4">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">

                {{-- Search --}}
                <div class="xl:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Search
                    </label>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Sale code, client, phone, land..."
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company
                    </label>

                    <select name="company_id"
                            id="company_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
                        <option value="">All Companies</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
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

                    <select name="branch_id"
                            id="branch_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">All Branches</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    data-company="{{ $branch->company_id }}"
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Project --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project
                    </label>

                    <select name="project_id"
                            id="project_id"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">All Projects</option>

                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select name="status"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                        <option value="">All Status</option>

                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                            Confirmed
                        </option>

                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                            Cancelled
                        </option>

                    </select>
                </div>

            </div>

            <div class="flex flex-wrap gap-2">

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-900">
                    <i class="bi bi-search"></i>
                    Filter
                </button>

                <a href="{{ route('admin.land-share-sales.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800">
                        Sale Records
                    </h2>

                    <p class="text-sm text-slate-500">
                        {{ $sales->total() }} total records
                    </p>
                </div>
            </div>
        </div>

        <div class="table-responsive">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase text-slate-500">

                    <tr>
                        <th class="px-4 py-3">Sale</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Land</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Share</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($sales as $sale)

                        <tr class="hover:bg-slate-50">

                            {{-- Sale --}}
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $sale->sale_code }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $sale->branch?->name }}
                                </div>
                            </td>

                            {{-- Client --}}
                            <td class="px-4 py-4">
                                <div class="font-medium text-slate-800">
                                    {{ $sale->client?->name ?? 'N/A' }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $sale->client?->phone }}
                                </div>
                            </td>

                            {{-- Land --}}
                            <td class="px-4 py-4">
                                <div class="font-medium text-slate-800">
                                    {{ $sale->land?->land_code }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $sale->land?->land_name }}
                                </div>
                            </td>

                            {{-- Project --}}
                            <td class="px-4 py-4">
                                {{ $sale->project?->project_name ?? 'N/A' }}
                            </td>

                            {{-- Share --}}
                            <td class="px-4 py-4">
                                <span class="font-semibold text-slate-800">
                                    {{ number_format((float) $sale->share_size, 4) }}
                                </span>

                                <span class="text-xs text-slate-500">
                                    {{ $sale->share_unit }}
                                </span>
                            </td>

                            {{-- Price --}}
                            <td class="px-4 py-4">
                                <div class="font-semibold text-slate-800">
                                    ৳ {{ number_format((float) $sale->land_share_price, 2) }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    ৳ {{ number_format((float) $sale->price_per_unit, 2) }}
                                    / {{ $sale->share_unit }}
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-4 text-slate-600">
                                {{ $sale->sale_date?->format('d M Y') }}
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">

                                @php
                                    $statusClasses = match($sale->status) {
                                        'draft' => 'bg-slate-100 text-slate-700',
                                        'confirmed' => 'bg-blue-100 text-blue-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClasses }}">
                                    {{ ucfirst($sale->status) }}
                                </span>

                            </td>

                            {{-- Action --}}
                            <td class="px-4 py-4">

                                <div class="flex justify-end gap-1">

                                    <a href="{{ route('admin.land-share-sales.show', $sale) }}"
                                       title="View"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.land-share-sales.edit', $sale) }}"
                                       title="Edit"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-50">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.land-share-sales.destroy', $sale) }}"
                                          class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 hover:bg-red-50">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">
                                        <i class="bi bi-receipt text-2xl text-slate-400"></i>
                                    </div>

                                    <h3 class="font-semibold text-slate-700">
                                        No land share sales found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first land share sale.
                                    </p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($sales->hasPages())
            <div class="border-t border-slate-200 px-4 py-4">
                {{ $sales->links() }}
            </div>
        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const company = document.getElementById('company_id');
    const branch = document.getElementById('branch_id');
    const project = document.getElementById('project_id');

    const selectedBranch = "{{ request('branch_id') }}";
    const selectedProject = "{{ request('project_id') }}";

    function filterBranches() {

        const companyId = company.value;

        [...branch.options].forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const match = !companyId ||
                option.dataset.company === companyId;

            option.hidden = !match;

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

        if (
            project.value &&
            (
                (companyId && project.selectedOptions[0]?.dataset.company !== companyId) ||
                (branchId && project.selectedOptions[0]?.dataset.branch !== branchId)
            )
        ) {
            project.value = '';
        }
    }

    company.addEventListener('change', filterBranches);
    branch.addEventListener('change', filterProjects);

    filterBranches();

    if (selectedBranch) {
        branch.value = selectedBranch;
        filterProjects();
    }

    if (selectedProject) {
        project.value = selectedProject;
    }

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (e) {

            if (!confirm('Are you sure you want to delete this land share sale?')) {
                e.preventDefault();
            }

        });

    });

});
</script>

@endpush