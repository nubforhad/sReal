@extends('admin.layouts.app')

@section('title', 'Clients')
@section('page-title', 'Client Management')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Client Management
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage clients, nominees, NID and documents.
            </p>
        </div>

        <a href="{{ route('admin.clients.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg
                  bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white
                  shadow-sm transition hover:bg-blue-700">
            <i class="bi bi-person-plus"></i>
            Add Client
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-green-200
                    bg-green-50 px-4 py-3 text-sm text-green-700">

            <i class="bi bi-check-circle-fill"></i>

            <span>{{ session('success') }}</span>

        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="flex items-center gap-3 rounded-xl border border-red-200
                    bg-red-50 px-4 py-3 text-sm text-red-700">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>{{ session('error') }}</span>

        </div>
    @endif


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-5 py-4">
            <div class="flex items-center gap-2">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                    <i class="bi bi-funnel text-blue-600"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Search & Filter
                    </h2>

                    <p class="text-xs text-slate-500">
                        Find clients by name, phone, NID or project.
                    </p>
                </div>

            </div>
        </div>


        <form method="GET"
              action="{{ route('admin.clients.index') }}"
              class="p-5">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Search
                    </label>

                    <div class="relative">

                        <i class="bi bi-search absolute left-3 top-1/2
                                  -translate-y-1/2 text-slate-400"></i>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Client ID, name, phone or NID"
                               class="w-full rounded-lg border border-slate-300
                                      py-2.5 pl-10 pr-3 text-sm
                                      focus:border-blue-500 focus:ring-2
                                      focus:ring-blue-100">

                    </div>

                </div>


                {{-- Company --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company
                    </label>

                    <select name="company_id"
                            id="filter_company"
                            class="w-full rounded-lg border border-slate-300
                                   bg-white px-3 py-2.5 text-sm
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

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
                            id="filter_branch"
                            class="w-full rounded-lg border border-slate-300
                                   bg-white px-3 py-2.5 text-sm
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

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
                            id="filter_project"
                            class="w-full rounded-lg border border-slate-300
                                   bg-white px-3 py-2.5 text-sm
                                   focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

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

            </div>


            <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('admin.clients.index') }}"
                   class="inline-flex items-center justify-center gap-2
                          rounded-lg border border-slate-300 bg-white
                          px-4 py-2.5 text-sm font-medium text-slate-700
                          hover:bg-slate-50">

                    <i class="bi bi-arrow-clockwise"></i>
                    Reset

                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2
                               rounded-lg bg-blue-600 px-4 py-2.5
                               text-sm font-semibold text-white
                               hover:bg-blue-700">

                    <i class="bi bi-search"></i>
                    Search

                </button>

            </div>

        </form>

    </div>


    {{-- Client Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4
                    sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-800">
                    Clients
                </h2>

                <p class="text-xs text-slate-500">
                    Total: {{ $clients->total() }} client(s)
                </p>
            </div>

        </div>


        <div class="table-responsive">

            <table class="w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase text-slate-500">

                    <tr>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Client
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Contact
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Company / Branch
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Project
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Nominee
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 font-semibold">
                            Status
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-right font-semibold">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($clients as $client)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Client --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    @if($client->photo)

                                        <img src="{{ asset('storage/' . $client->photo) }}"
                                             alt="{{ $client->name }}"
                                             class="h-10 w-10 rounded-full object-cover ring-2 ring-slate-100">

                                    @else

                                        <div class="flex h-10 w-10 items-center justify-center
                                                    rounded-full bg-blue-50 text-blue-600">

                                            <i class="bi bi-person"></i>

                                        </div>

                                    @endif


                                    <div class="min-w-0">

                                        <p class="truncate font-semibold text-slate-800">
                                            {{ $client->name }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-blue-600">
                                            {{ $client->client_code }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Contact --}}
                            <td class="px-5 py-4">

                                <div class="space-y-1">

                                    <p class="flex items-center gap-1.5 text-slate-700">
                                        <i class="bi bi-telephone text-xs text-slate-400"></i>
                                        {{ $client->phone }}
                                    </p>

                                    @if($client->nid)

                                        <p class="flex items-center gap-1.5 text-xs text-slate-500">
                                            <i class="bi bi-card-text text-xs text-slate-400"></i>
                                            NID: {{ $client->nid }}
                                        </p>

                                    @endif

                                </div>

                            </td>


                            {{-- Company / Branch --}}
                            <td class="px-5 py-4">

                                <p class="font-medium text-slate-700">
                                    {{ $client->company?->name ?? '-' }}
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    {{ $client->branch?->name ?? '-' }}
                                </p>

                            </td>


                            {{-- Project --}}
                            <td class="px-5 py-4">

                                @if($client->project)

                                    <p class="font-medium text-slate-700">
                                        {{ $client->project->project_name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $client->project->project_code }}
                                    </p>

                                @else

                                    <span class="text-slate-400">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- Nominee --}}
                            <td class="px-5 py-4">

                                @if($client->nominee_name)

                                    <p class="font-medium text-slate-700">
                                        {{ $client->nominee_name }}
                                    </p>

                                    @if($client->nominee_relation)

                                        <span class="mt-1 inline-flex rounded-full
                                                     bg-green-50 px-2 py-1 text-xs
                                                     font-medium text-green-700">
                                            {{ $client->nominee_relation }}
                                        </span>

                                    @endif

                                @else

                                    <span class="text-xs text-slate-400">
                                        Not Added
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @if($client->status === 'active')

                                    <span class="inline-flex items-center gap-1 rounded-full
                                                 bg-green-50 px-2.5 py-1 text-xs
                                                 font-semibold text-green-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        Active

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1 rounded-full
                                                 bg-red-50 px-2.5 py-1 text-xs
                                                 font-semibold text-red-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center justify-end gap-1">

                                    {{-- View --}}
                                    <a href="{{ route('admin.clients.show', $client) }}"
                                       title="View"
                                       class="inline-flex h-9 w-9 items-center justify-center
                                              rounded-lg text-slate-500
                                              hover:bg-blue-50 hover:text-blue-600">

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('admin.clients.edit', $client) }}"
                                       title="Edit"
                                       class="inline-flex h-9 w-9 items-center justify-center
                                              rounded-lg text-slate-500
                                              hover:bg-amber-50 hover:text-amber-600">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form action="{{ route('admin.clients.destroy', $client) }}"
                                          method="POST"
                                          class="delete-client-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete"
                                                class="inline-flex h-9 w-9 items-center justify-center
                                                       rounded-lg text-slate-500
                                                       hover:bg-red-50 hover:text-red-600">

                                            <i class="bi bi-trash3"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-14 w-14 items-center justify-center
                                                rounded-full bg-slate-100">

                                        <i class="bi bi-people text-2xl text-slate-400"></i>

                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-700">
                                        No clients found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add a new client to get started.
                                    </p>

                                    <a href="{{ route('admin.clients.create') }}"
                                       class="mt-4 inline-flex items-center gap-2
                                              rounded-lg bg-blue-600 px-4 py-2
                                              text-sm font-medium text-white
                                              hover:bg-blue-700">

                                        <i class="bi bi-person-plus"></i>
                                        Add Client

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($clients->hasPages())

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $clients->links() }}
            </div>

        @endif

    </div>

</div>

@endsection


@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('filter_company');
    const branchSelect = document.getElementById('filter_branch');
    const projectSelect = document.getElementById('filter_project');

    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = option.dataset.company !== companyId;
        });

        if (
            branchSelect.value &&
            branchSelect.selectedOptions[0]?.dataset.company !== companyId
        ) {
            branchSelect.value = '';
        }

        filterProjects();
    }


    function filterProjects() {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const matchesCompany =
                !companyId || option.dataset.company === companyId;

            const matchesBranch =
                !branchId || option.dataset.branch === branchId;

            option.hidden = !(matchesCompany && matchesBranch);
        });

        if (
            projectSelect.value &&
            (
                (companyId &&
                 projectSelect.selectedOptions[0]?.dataset.company !== companyId)
                ||
                (branchId &&
                 projectSelect.selectedOptions[0]?.dataset.branch !== branchId)
            )
        ) {
            projectSelect.value = '';
        }
    }


    companySelect.addEventListener('change', filterBranches);

    branchSelect.addEventListener('change', filterProjects);

    filterBranches();


    // SweetAlert Delete Confirmation
    document.querySelectorAll('.delete-client-form')
        .forEach(form => {

            form.addEventListener('submit', function (event) {

                event.preventDefault();

                if (typeof Swal === 'undefined') {
                    if (confirm('Are you sure you want to delete this client?')) {
                        form.submit();
                    }

                    return;
                }

                Swal.fire({
                    title: 'Delete Client?',
                    text: 'All client and nominee documents will also be deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel',
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            });

        });

});
</script>

@endpush 
