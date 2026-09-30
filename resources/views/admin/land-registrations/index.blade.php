@extends('admin.layouts.app')

@section('title', 'Land Registrations')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Land Registrations
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage registered land records and registration documents.
            </p>
        </div>
        <a href="{{ route('admin.land-registrations.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
            <i class="bi bi-plus-lg"></i>
            Add Registration
        </a>
    </div>
    {{-- Success Message --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            <i class="bi bi-check-circle mr-1"></i>
            {{ session('success') }}
        </div>
    @endif
    {{-- Error Message --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET"
              action="{{ route('admin.land-registrations.index') }}"
              class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">

            {{-- Search --}}
            <div class="lg:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Search
                </label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Registration code, deed no, client..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Company --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Company
                </label>

                <select name="company_id"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">All Companies</option>

                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                            @selected(request('company_id') == $company->id)>
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
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">All Branches</option>

                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}"
                            @selected(request('branch_id') == $branch->id)>
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
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">All Projects</option>

                    @foreach($projects as $project)
                        <option value="{{ $project->id }}"
                            @selected(request('project_id') == $project->id)>
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
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    <option value="">All Status</option>

                    <option value="pending"
                        @selected(request('status') === 'pending')>
                        Pending
                    </option>

                    <option value="processing"
                        @selected(request('status') === 'processing')>
                        Processing
                    </option>

                    <option value="completed"
                        @selected(request('status') === 'completed')>
                        Completed
                    </option>

                    <option value="cancelled"
                        @selected(request('status') === 'cancelled')>
                        Cancelled
                    </option>

                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex items-end gap-2 lg:col-span-5">

                <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="bi bi-search mr-1"></i>
                    Filter
                </button>

                <a href="{{ route('admin.land-registrations.index') }}"
                   class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Reset
                </a>

            </div>

        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Registration
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Client
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Project
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Deed No
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Date
                        </th>

                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                            Total Cost
                        </th>

                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Status
                        </th>

                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase text-slate-500">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($registrations as $registration)

                        <tr class="hover:bg-slate-50">

                            <td class="whitespace-nowrap px-4 py-4">
                                <div class="font-semibold text-slate-800">
                                    {{ $registration->registration_code }}
                                </div>

                                @if($registration->company)
                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $registration->company->name }}
                                        @if($registration->branch)
                                            · {{ $registration->branch->name }}
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-4">
                                <div class="font-medium text-slate-800">
                                    {{ $registration->client?->name ?? 'N/A' }}
                                </div>

                                @if($registration->client?->phone)
                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $registration->client->phone }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-sm text-slate-700">
                                {{ $registration->project?->project_name ?? 'N/A' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-slate-700">
                                {{ $registration->deed_no ?: '—' }}
                            </td>

                            <td class="px-4 py-4 text-sm text-slate-600">
                                {{ $registration->registration_date
                                    ? \Carbon\Carbon::parse($registration->registration_date)->format('d M Y')
                                    : '—'
                                }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-right text-sm font-semibold text-slate-800">
                                ৳ {{ number_format((float) $registration->total_cost, 2) }}
                            </td>

                            <td class="px-4 py-4 text-center">

                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'processing' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'completed' => 'bg-green-50 text-green-700 border-green-200',
                                        'cancelled' => 'bg-red-50 text-red-700 border-red-200',
                                    ];
                                @endphp

                                <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusClasses[$registration->status] ?? 'bg-slate-50 text-slate-700 border-slate-200' }}">
                                    {{ ucfirst($registration->status) }}
                                </span>

                            </td>

                            <td class="whitespace-nowrap px-4 py-4 text-right">

                                <div class="flex justify-end gap-1">

                                    <a href="{{ route('admin.land-registrations.show', $registration) }}"
                                       title="View"
                                       class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 hover:text-blue-600">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.land-registrations.edit', $registration) }}"
                                       title="Edit"
                                       class="rounded-lg p-2 text-slate-600 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.land-registrations.destroy', $registration) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this registration?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete"
                                                class="rounded-lg p-2 text-slate-600 hover:bg-red-50 hover:text-red-600">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8"
                                class="px-4 py-12 text-center">

                                <div class="text-slate-400">
                                    <i class="bi bi-file-earmark-text text-4xl"></i>
                                </div>

                                <p class="mt-3 text-sm font-medium text-slate-600">
                                    No land registrations found.
                                </p>

                                <a href="{{ route('admin.land-registrations.create') }}"
                                   class="mt-3 inline-block text-sm font-semibold text-blue-600 hover:text-blue-700">
                                    Create first registration
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($registrations->hasPages())
            <div class="border-t border-slate-200 px-4 py-4">
                {{ $registrations->links() }}
            </div>
        @endif

    </div>

</div>

@endsection