@extends('admin.layouts.app')

@section('title', 'RAJUK Approval Management')

@section('content')

<div class="mx-auto max-w-8xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                RAJUK Approval Management
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage project-wise RAJUK plans and approvals.
            </p>
        </div>

        <a href="{{ route('admin.rajuk-approvals.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

            <i class="bi bi-plus-lg"></i>

            Add New Approval
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">

            <i class="bi bi-check-circle mr-2"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">

            <i class="bi bi-exclamation-circle mr-2"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- Statistics --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Total --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Total Applications
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-slate-800">
                        {{ $totalApplications }}
                    </h3>

                </div>

                <div class="rounded-lg bg-blue-50 p-3 text-blue-600">

                    <i class="bi bi-building text-xl"></i>

                </div>

            </div>

        </div>


        {{-- Approved --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Approved
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-green-600">
                        {{ $approved }}
                    </h3>

                </div>

                <div class="rounded-lg bg-green-50 p-3 text-green-600">

                    <i class="bi bi-check-circle text-xl"></i>

                </div>

            </div>

        </div>


        {{-- Under Review --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Under Review
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-amber-600">
                        {{ $underReview }}
                    </h3>

                </div>

                <div class="rounded-lg bg-amber-50 p-3 text-amber-600">

                    <i class="bi bi-hourglass-split text-xl"></i>

                </div>

            </div>

        </div>


        {{-- Rejected --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Rejected
                    </p>

                    <h3 class="mt-2 text-2xl font-bold text-red-600">
                        {{ $rejected }}
                    </h3>

                </div>

                <div class="rounded-lg bg-red-50 p-3 text-red-600">

                    <i class="bi bi-x-circle text-xl"></i>

                </div>

            </div>

        </div>

    </div>


    {{-- Search & Filter --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET"
              action="{{ route('admin.rajuk-approvals.index') }}"
              class="grid grid-cols-1 gap-3 md:grid-cols-4">

            {{-- Search --}}
            <div class="md:col-span-2">

                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Application no, applicant, project..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

            </div>


            {{-- Status --}}
            <div>

                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Approval Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                    <option value="">
                        All Status
                    </option>

                    @foreach([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'on_hold' => 'On Hold',
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            {{ request('status') === $value ? 'selected' : '' }}
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2">

                <button
                    type="submit"
                    class="flex-1 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                >

                    <i class="bi bi-search mr-1"></i>

                    Search

                </button>


                <a
                    href="{{ route('admin.rajuk-approvals.index') }}"
                    class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-slate-600 hover:bg-slate-50"
                    title="Reset"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                </a>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-800">
                RAJUK Approval List
            </h2>

            <span class="text-sm text-slate-500">
                Total: {{ $rajukApprovals->total() }}
            </span>

        </div>


        {{-- Responsive Table --}}
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            SL
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Application
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Project
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Applicant
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Submission Date
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Approval No.
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                            Status
                        </th>

                        <th class="whitespace-nowrap px-5 py-3 text-center text-xs font-semibold uppercase text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($rajukApprovals as $index => $approval)

                        <tr class="transition hover:bg-slate-50">

                            {{-- SL --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">

                                {{ $rajukApprovals->firstItem() + $index }}

                            </td>


                            {{-- Application --}}
                            <td class="whitespace-nowrap px-5 py-4">

                                <p class="text-sm font-semibold text-slate-800">

                                    {{ $approval->application_no ?: 'N/A' }}

                                </p>

                                <p class="mt-1 text-xs text-slate-500">

                                    ID: {{ $approval->id }}

                                </p>

                            </td>


                            {{-- Project --}}
                            <td class="px-5 py-4">

                                @if($approval->project)

                                    <p class="whitespace-nowrap text-sm font-medium text-slate-800">

                                        {{ $approval->project->project_name }}

                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">

                                        {{ $approval->project->project_code ?? 'N/A' }}

                                    </p>

                                @else

                                    <p class="text-sm text-red-500">
                                        Project Not Found
                                    </p>

                                @endif

                                <p class="mt-1 text-xs text-slate-400">

                                    {{ $approval->plan_type ?: 'Plan Type N/A' }}

                                </p>

                            </td>


                            {{-- Applicant --}}
                            <td class="px-5 py-4">

                                <p class="whitespace-nowrap text-sm font-medium text-slate-800">

                                    {{ $approval->applicant_name }}

                                </p>

                                <p class="mt-1 text-xs text-slate-500">

                                    {{ $approval->applicant_phone ?: 'N/A' }}

                                </p>

                            </td>


                            {{-- Submission Date --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">

                                {{ $approval->submission_date?->format('d M Y') ?? 'N/A' }}

                            </td>


                            {{-- Approval Number --}}
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">

                                {{ $approval->approval_number ?: 'N/A' }}

                            </td>


                            {{-- Status --}}
                            <td class="whitespace-nowrap px-5 py-4">

                                @php

                                    $statusClasses = [

                                        'draft' =>
                                            'bg-slate-100 text-slate-700',

                                        'submitted' =>
                                            'bg-blue-100 text-blue-700',

                                        'under_review' =>
                                            'bg-amber-100 text-amber-700',

                                        'approved' =>
                                            'bg-green-100 text-green-700',

                                        'rejected' =>
                                            'bg-red-100 text-red-700',

                                        'on_hold' =>
                                            'bg-orange-100 text-orange-700',

                                    ];

                                    $statusClass = $statusClasses[$approval->status]
                                        ?? 'bg-slate-100 text-slate-700';

                                @endphp


                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">

                                    {{ ucwords(str_replace('_', ' ', $approval->status)) }}

                                </span>

                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-5 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('admin.rajuk-approvals.show', $approval->id) }}"
                                        title="View"
                                        class="rounded-lg bg-blue-50 p-2 text-blue-600 transition hover:bg-blue-100"
                                    >

                                        <i class="bi bi-eye"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.rajuk-approvals.edit', $approval->id) }}"
                                        title="Edit"
                                        class="rounded-lg bg-amber-50 p-2 text-amber-600 transition hover:bg-amber-100"
                                    >

                                        <i class="bi bi-pencil-square"></i>

                                    </a>


                                    {{-- Delete --}}
                                    <form
                                        action="{{ route('admin.rajuk-approvals.destroy', $approval->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this RAJUK approval?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Delete"
                                            class="rounded-lg bg-red-50 p-2 text-red-600 transition hover:bg-red-100"
                                        >

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="px-5 py-12 text-center">

                                <div class="flex flex-col items-center">

                                    <i class="bi bi-building text-4xl text-slate-300"></i>

                                    <p class="mt-3 font-medium text-slate-600">

                                        No RAJUK approvals found.

                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">

                                        Add your first RAJUK approval record.

                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($rajukApprovals->hasPages())

            <div class="border-t border-slate-200 px-5 py-4">

                {{ $rajukApprovals->links() }}

            </div>

        @endif

    </div>

</div>

@endsection