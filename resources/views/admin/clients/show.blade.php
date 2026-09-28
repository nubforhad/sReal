```blade
@extends('admin.layouts.app')

@section('title', 'Client Details')
@section('page-title', 'Client Details')

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <i class="bi bi-person-vcard text-xl"></i>
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Client Details
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $client->client_code }}
                    </p>
                </div>
            </div>
        </div>


        <div class="flex flex-wrap gap-2">

            {{-- Print --}}
            <button type="button"
                    onclick="window.print()"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-900">
                <i class="bi bi-printer"></i>
                Print
            </button>


            {{-- Edit --}}
            <a href="{{ route('admin.clients.edit', $client) }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>


            {{-- Back --}}
            <a href="{{ route('admin.clients.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CLIENT PROFILE HEADER --}}
    {{-- ========================================================= --}}

    <div class="erp-card overflow-hidden">

        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-6 sm:px-7">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                {{-- Photo --}}
                <div class="shrink-0">

                    @if ($client->photo)

                        <img src="{{ asset('storage/' . $client->photo) }}"
                             alt="{{ $client->name }}"
                             class="h-24 w-24 rounded-2xl border-4 border-white/80 object-cover shadow-lg">

                    @else

                        <div class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white/80 bg-white text-4xl font-bold text-blue-600 shadow-lg">
                            {{ strtoupper(substr($client->name, 0, 1)) }}
                        </div>

                    @endif

                </div>


                {{-- Name --}}
                <div class="flex-1">

                    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                        <h2 class="text-2xl font-bold text-white">
                            {{ $client->name }}
                        </h2>

                        @if ($client->status === 'active')

                            <span class="inline-flex w-fit items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                                Active
                            </span>

                        @else

                            <span class="inline-flex w-fit items-center gap-1 rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>
                                Inactive
                            </span>

                        @endif

                    </div>


                    <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-sm text-blue-100">

                        <span class="inline-flex items-center gap-2">
                            <i class="bi bi-person-badge"></i>
                            {{ $client->client_code }}
                        </span>

                        <span class="inline-flex items-center gap-2">
                            <i class="bi bi-telephone"></i>
                            {{ $client->phone }}
                        </span>

                        @if ($client->email)
                            <span class="inline-flex items-center gap-2">
                                <i class="bi bi-envelope"></i>
                                {{ $client->email }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- =================== BUSINESS INFORMATION ========= --}}
    <div class="erp-card overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div>
                    <h2 class="font-semibold text-slate-800">
                        Business Assignment
                    </h2>
                    <p class="text-xs text-slate-500">
                        Company, branch and project information
                    </p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">
            {{-- Company --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Company
                </p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $client->company?->name ?? 'N/A' }}
                </p>
            </div>
            {{-- Branch --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Branch
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ $client->branch?->name ?? 'N/A' }}
                </p>
            </div>


            {{-- Project --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Project
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ $client->project?->project_name ?? 'N/A' }}
                </p>

                @if ($client->project?->project_code)
                    <p class="mt-1 text-xs text-slate-500">
                        Code: {{ $client->project->project_code }}
                    </p>
                @endif
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PERSONAL INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                    <i class="bi bi-person"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Personal Information
                    </h2>

                    <p class="text-xs text-slate-500">
                        Client personal details
                    </p>
                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Name --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Client Name
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ $client->name }}
                </p>
            </div>


            {{-- Father --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Father's Name
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->father_name ?: 'N/A' }}
                </p>
            </div>


            {{-- Mother --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Mother's Name
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->mother_name ?: 'N/A' }}
                </p>
            </div>


            {{-- Spouse --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Spouse Name
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->spouse_name ?: 'N/A' }}
                </p>
            </div>


            {{-- DOB --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Date of Birth
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->date_of_birth?->format('d M Y') ?? 'N/A' }}
                </p>
            </div>


            {{-- Occupation --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Occupation
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->occupation ?: 'N/A' }}
                </p>
            </div>


            {{-- NID --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    NID Number
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $client->nid ?: 'N/A' }}
                </p>
            </div>


            {{-- Phone --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Phone
                </p>

                <p class="mt-1 font-medium text-slate-800">
                    {{ $client->phone }}
                </p>
            </div>


            {{-- Alternate Phone --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Alternate Phone
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->alternate_phone ?: 'N/A' }}
                </p>
            </div>


            {{-- Email --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Email
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->email ?: 'N/A' }}
                </p>
            </div>


            {{-- City --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    City
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->city ?: 'N/A' }}
                </p>
            </div>


            {{-- Address --}}
            <div class="sm:col-span-2 lg:col-span-3">
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Address
                </p>

                <p class="mt-1 whitespace-pre-line text-slate-700">
                    {{ $client->address ?: 'N/A' }}
                </p>
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CLIENT DOCUMENTS --}}
    {{-- ========================================================= --}}

    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Client Documents
                    </h2>

                    <p class="text-xs text-slate-500">
                        Uploaded client documents
                    </p>
                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Client Photo --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Client Photo
                </p>

                @if ($client->photo)

                    <img src="{{ asset('storage/' . $client->photo) }}"
                         alt="{{ $client->name }}"
                         class="h-40 w-40 rounded-xl border border-slate-200 object-cover">

                @else

                    <div class="flex h-40 w-40 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                        <i class="bi bi-person text-4xl"></i>
                    </div>

                @endif

            </div>


            {{-- NID Document --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    NID Document
                </p>

                @if ($client->nid_document)

                    <a href="{{ asset('storage/' . $client->nid_document) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        <i class="bi bi-file-earmark-text"></i>
                        View NID Document
                    </a>

                @else

                    <p class="text-sm text-slate-400">
                        No document uploaded.
                    </p>

                @endif

            </div>


            {{-- Other Document --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Other Document
                </p>

                @if ($client->other_document)

                    <a href="{{ asset('storage/' . $client->other_document) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                        <i class="bi bi-file-earmark"></i>
                        View Document
                    </a>

                @else

                    <p class="text-sm text-slate-400">
                        No document uploaded.
                    </p>

                @endif

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- NOMINEE --}}
    {{-- ========================================================= --}}

    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-100 text-orange-600">
                    <i class="bi bi-person-vcard"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Nominee Information
                    </h2>

                    <p class="text-xs text-slate-500">
                        Nominee personal and contact information
                    </p>
                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Nominee Name --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Nominee Name
                </p>

                <p class="mt-1 font-semibold text-slate-800">
                    {{ $client->nominee_name ?: 'N/A' }}
                </p>
            </div>


            {{-- Relation --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Relationship
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->nominee_relation ?: 'N/A' }}
                </p>
            </div>


            {{-- Phone --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Nominee Phone
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->nominee_phone ?: 'N/A' }}
                </p>
            </div>


            {{-- NID --}}
            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Nominee NID
                </p>

                <p class="mt-1 text-slate-700">
                    {{ $client->nominee_nid ?: 'N/A' }}
                </p>
            </div>


            {{-- Address --}}
            <div class="sm:col-span-2">

                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Nominee Address
                </p>

                <p class="mt-1 whitespace-pre-line text-slate-700">
                    {{ $client->nominee_address ?: 'N/A' }}
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- NOMINEE DOCUMENTS --}}
    {{-- ========================================================= --}}

    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-pink-100 text-pink-600">
                    <i class="bi bi-folder2-open"></i>
                </div>

                <div>
                    <h2 class="font-semibold text-slate-800">
                        Nominee Documents
                    </h2>

                    <p class="text-xs text-slate-500">
                        Uploaded nominee documents
                    </p>
                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Nominee Photo --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Nominee Photo
                </p>

                @if ($client->nominee_photo)

                    <img src="{{ asset('storage/' . $client->nominee_photo) }}"
                         alt="{{ $client->nominee_name }}"
                         class="h-40 w-40 rounded-xl border border-slate-200 object-cover">

                @else

                    <div class="flex h-40 w-40 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                        <i class="bi bi-person text-4xl"></i>
                    </div>

                @endif

            </div>


            {{-- Nominee NID --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Nominee NID Document
                </p>

                @if ($client->nominee_nid_document)

                    <a href="{{ asset('storage/' . $client->nominee_nid_document) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-lg bg-orange-50 px-4 py-3 text-sm font-semibold text-orange-700 transition hover:bg-orange-100">
                        <i class="bi bi-file-earmark-text"></i>
                        View NID Document
                    </a>

                @else

                    <p class="text-sm text-slate-400">
                        No document uploaded.
                    </p>

                @endif

            </div>


            {{-- Nominee Other --}}
            <div class="rounded-xl border border-slate-200 bg-white p-4">

                <p class="mb-3 text-sm font-semibold text-slate-700">
                    Nominee Other Document
                </p>

                @if ($client->nominee_other_document)

                    <a href="{{ asset('storage/' . $client->nominee_other_document) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                        <i class="bi bi-file-earmark"></i>
                        View Document
                    </a>

                @else

                    <p class="text-sm text-slate-400">
                        No document uploaded.
                    </p>

                @endif

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- REMARKS --}}
    {{-- ========================================================= --}}

    @if ($client->remarks)

        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-200 text-slate-600">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <h2 class="font-semibold text-slate-800">
                        Remarks
                    </h2>

                </div>

            </div>

            <div class="p-5">
                <p class="whitespace-pre-line text-sm leading-6 text-slate-700">
                    {{ $client->remarks }}
                </p>
            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- RECORD INFORMATION --}}
    {{-- ========================================================= --}}

    <div class="erp-card">

        <div class="grid grid-cols-1 gap-4 p-5 text-sm sm:grid-cols-2">

            <div>
                <span class="text-slate-400">
                    Created:
                </span>

                <span class="font-medium text-slate-700">
                    {{ $client->created_at?->format('d M Y, h:i A') }}
                </span>
            </div>

            <div class="sm:text-right">
                <span class="text-slate-400">
                    Last Updated:
                </span>

                <span class="font-medium text-slate-700">
                    {{ $client->updated_at?->format('d M Y, h:i A') }}
                </span>
            </div>

        </div>

    </div>


</div>


{{-- ========================================================= --}}
{{-- PRINT CSS --}}
{{-- ========================================================= --}}

@push('styles')
<style>

    @media print {

        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            background: #ffffff !important;
            color: #000000 !important;
        }

        nav,
        aside,
        header,
        footer,
        .print-hidden {
            display: none !important;
        }

        .page-content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .erp-card {
            break-inside: avoid;
            box-shadow: none !important;
            border: 1px solid #d1d5db !important;
        }

        button,
        a {
            text-decoration: none !important;
        }

        .bg-gradient-to-r {
            background: #2563eb !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

    }

</style>
@endpush

@endsection 