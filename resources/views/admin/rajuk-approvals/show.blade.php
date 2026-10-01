@extends('admin.layouts.app')

@section('title', 'RAJUK Approval Details')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                RAJUK Approval Details
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                View complete RAJUK approval information
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.rajuk-approvals.index') }}"
               class="inline-flex items-center rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <i class="bi bi-arrow-left mr-2"></i>
                Back
            </a>

            <a href="{{ route('admin.rajuk-approvals.edit', $rajukApproval) }}"
               class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                <i class="bi bi-pencil-square mr-2"></i>
                Edit
            </a>
 
            <a href="{{ route('admin.rajuk-approvals.print', $rajukApproval) }}"
            target="_blank"
            class="inline-flex items-center rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-white hover:bg-slate-900">
                <i class="bi bi-printer mr-2"></i>
                Print
            </a> 

        </div>
    </div>

    {{-- Print Header --}}
    <div class="hidden print:block">
        <div class="mb-5 border-b-2 border-slate-800 pb-3 text-center">
            <h1 class="text-2xl font-bold text-slate-900">
                RAJUK APPROVAL DETAILS
            </h1>

            <p class="mt-1 text-sm text-slate-600">
                Real Estate Management System
            </p>
        </div>
    </div>

    {{-- Status --}}
    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Approval Status
                </p>

                @php
                    $statusClasses = [
                        'draft' => 'bg-slate-100 text-slate-700',
                        'submitted' => 'bg-blue-100 text-blue-700',
                        'under_review' => 'bg-yellow-100 text-yellow-700',
                        'approved' => 'bg-green-100 text-green-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        'on_hold' => 'bg-orange-100 text-orange-700',
                    ];
                @endphp

                <span class="mt-2 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClasses[$rajukApproval->status] ?? 'bg-slate-100 text-slate-700' }}">
                    {{ ucwords(str_replace('_', ' ', $rajukApproval->status)) }}
                </span>
            </div>

            <div class="text-left sm:text-right">
                <p class="text-sm text-slate-500">
                    Application No.
                </p>
                <p class="text-lg font-bold text-slate-800">
                    {{ $rajukApproval->application_no ?: 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Company / Branch / Project --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-building mr-2"></i>
                Company, Branch & Project
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Company
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->company->name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Branch
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->branch->name ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Project
                </p>
                <p class="mt-1 font-semibold text-blue-700">
                    {{ $rajukApproval->project->project_name ?? 'N/A' }}
                </p>

                @if($rajukApproval->project?->project_code)
                    <p class="mt-1 text-xs text-slate-500">
                        Code: {{ $rajukApproval->project->project_code }}
                    </p>
                @endif
            </div>

        </div>
    </div>

    {{-- Applicant Information --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-person mr-2"></i>
                Applicant Information
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Applicant Name
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->applicant_name }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Applicant Phone
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->applicant_phone ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Approval Number
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->approval_number ?: 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Land Information --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-geo-alt mr-2"></i>
                Land Information
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3 lg:grid-cols-5">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Plot Number
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->plot_number ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Road Number
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->road_number ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Block
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->block ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Mouza
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->mouza ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Land Area
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->land_area ?: 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Building Information --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-buildings mr-2"></i>
                Building Information
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-5">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Plan Type
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->plan_type ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Number of Floors
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->number_of_floors ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Number of Flats
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->number_of_flats ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Architect
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->architect_name ?: 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Consultant
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->consultant_name ?: 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Dates --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-calendar-event mr-2"></i>
                Application Timeline
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Application Date
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->application_date?->format('d M Y') ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Submission Date
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $rajukApproval->submission_date?->format('d M Y') ?? 'N/A' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-500">
                    Approval Date
                </p>
                <p class="mt-1 font-semibold text-green-700">
                    {{ $rajukApproval->approval_date?->format('d M Y') ?? 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Documents --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm print:hidden">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-file-earmark-text mr-2"></i>
                Documents
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-4 p-5 md:grid-cols-2">

            {{-- Plan Document --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                            <i class="bi bi-file-earmark-pdf text-xl"></i>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-800">
                                Plan Document
                            </p>

                            @if($rajukApproval->plan_document)
                                <p class="text-xs text-green-600">
                                    Document uploaded
                                </p>
                            @else
                                <p class="text-xs text-slate-500">
                                    No document
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($rajukApproval->plan_document)
                        <a href="{{ asset('storage/' . $rajukApproval->plan_document) }}"
                           target="_blank"
                           class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
                            <i class="bi bi-eye mr-1"></i>
                            View
                        </a>
                    @endif

                </div>
            </div>

            {{-- Approval Document --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-600">
                            <i class="bi bi-file-earmark-check text-xl"></i>
                        </div>

                        <div>
                            <p class="font-semibold text-slate-800">
                                Approval Document
                            </p>

                            @if($rajukApproval->approval_document)
                                <p class="text-xs text-green-600">
                                    Document uploaded
                                </p>
                            @else
                                <p class="text-xs text-slate-500">
                                    No document
                                </p>
                            @endif
                        </div>
                    </div>

                    @if($rajukApproval->approval_document)
                        <a href="{{ asset('storage/' . $rajukApproval->approval_document) }}"
                           target="_blank"
                           class="rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700">
                            <i class="bi bi-eye mr-1"></i>
                            View
                        </a>
                    @endif

                </div>
            </div>

        </div>
    </div>

    {{-- Remarks --}}
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <h2 class="font-semibold text-slate-800">
                <i class="bi bi-chat-left-text mr-2"></i>
                Remarks
            </h2>
        </div>

        <div class="p-5">
            <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                {{ $rajukApproval->remarks ?: 'No remarks available.' }}
            </p>
        </div>

    </div>

    {{-- Print Footer --}}
    <div class="hidden print:block">
        <div class="mt-6 border-t border-slate-300 pt-3 text-center text-xs text-slate-500">
            Printed on {{ now()->format('d M Y h:i A') }}
        </div>
    </div>

</div>

{{-- A4 Print CSS --}}
<style>
    @media print {

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        html,
        body {
            width: 210mm;
            min-height: 297mm;
            background: #fff !important;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            font-size: 11px;
        }

        nav,
        aside,
        header,
        footer {
            display: none !important;
        }

        .print\:hidden {
            display: none !important;
        }

        .print\:block {
            display: block !important;
        }

        .mx-auto {
            max-width: none !important;
        }

        .shadow-sm {
            box-shadow: none !important;
        }

        .rounded-xl,
        .rounded-lg {
            border-radius: 0 !important;
        }

        .space-y-6 > :not([hidden]) ~ :not([hidden]) {
            margin-top: 10px !important;
        }

        .p-5 {
            padding: 10px !important;
        }

        .py-4 {
            padding-top: 7px !important;
            padding-bottom: 7px !important;
        }

        .border {
            border-color: #cbd5e1 !important;
        }

        a {
            color: inherit !important;
            text-decoration: none !important;
        }
    }
</style>

@endsection