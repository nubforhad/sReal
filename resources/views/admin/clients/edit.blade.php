@extends('admin.layouts.app')

@section('title', 'Edit Client')
@section('page-title', 'Edit Client')

@section('content')

<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit Client
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Update client, nominee and document information.
            </p>
        </div>
        <a href="{{ route('admin.clients.show', $client) }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
            <i class="bi bi-eye"></i>
            View Client
        </a>
    </div>
    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex gap-3">
                <i class="bi bi-exclamation-triangle-fill mt-0.5 text-red-500"></i>
                <div>
                    <h3 class="text-sm font-semibold text-red-800">
                        Please fix the following errors:
                    </h3>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="erp-card overflow-hidden">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <i class="bi bi-diagram-3"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Business Information
                        </h2>
                        <p class="text-xs text-slate-500">
                            Company, branch and project assignment
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">
                {{-- Company --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select name="company_id"
                            id="company_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Select Company</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id', $client->company_id) == $company->id ? 'selected' : '' }}>
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
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>
                    <select name="branch_id"
                            id="branch_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Select Branch</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    data-company="{{ $branch->company_id }}"
                                {{ old('branch_id', $client->branch_id) == $branch->id ? 'selected' : '' }}>
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
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id"
                            id="project_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option value="">Select Project</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                {{ old('project_id', $client->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                                ({{ $project->project_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>


        {{-- ======  CLIENT BASIC INFORMATION ============= --}}

        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Client Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Basic personal information
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Client ID --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Client ID
                    </label>

                    <input type="text"
                           value="{{ $client->client_code }}"
                           readonly
                           class="w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2.5 text-sm font-medium text-slate-600">
                </div>


                {{-- Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Client Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $client->name) }}"
                           required
                           placeholder="Enter client name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Father's Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Father's Name
                    </label>

                    <input type="text"
                           name="father_name"
                           value="{{ old('father_name', $client->father_name) }}"
                           placeholder="Father's name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Mother's Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Mother's Name
                    </label>

                    <input type="text"
                           name="mother_name"
                           value="{{ old('mother_name', $client->mother_name) }}"
                           placeholder="Mother's name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Spouse --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Spouse Name
                    </label>

                    <input type="text"
                           name="spouse_name"
                           value="{{ old('spouse_name', $client->spouse_name) }}"
                           placeholder="Spouse name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- DOB --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Date of Birth
                    </label>

                    <input type="date"
                           name="date_of_birth"
                           value="{{ old('date_of_birth', optional($client->date_of_birth)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Occupation --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Occupation
                    </label>

                    <input type="text"
                           name="occupation"
                           value="{{ old('occupation', $client->occupation) }}"
                           placeholder="Occupation"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- CONTACT INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-100 text-green-600">
                        <i class="bi bi-telephone"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Contact Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Phone, email and address
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Phone --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Phone <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $client->phone) }}"
                           required
                           placeholder="01XXXXXXXXX"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Alternate Phone --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Alternate Phone
                    </label>

                    <input type="text"
                           name="alternate_phone"
                           value="{{ old('alternate_phone', $client->alternate_phone) }}"
                           placeholder="Alternative phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Email --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', $client->email) }}"
                           placeholder="client@example.com"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- NID --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        NID Number
                    </label>

                    <input type="text"
                           name="nid"
                           value="{{ old('nid', $client->nid) }}"
                           placeholder="National ID number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- City --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        City
                    </label>

                    <input type="text"
                           name="city"
                           value="{{ old('city', $client->city) }}"
                           placeholder="City"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Address --}}
                <div class="md:col-span-3">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Address
                    </label>

                    <textarea name="address"
                              rows="3"
                              placeholder="Full address"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('address', $client->address) }}</textarea>
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
                            Existing files will remain unless a new file is uploaded.
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Photo --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Client Photo
                    </label>

                    @if ($client->photo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $client->photo) }}"
                                 alt="Client Photo"
                                 class="h-24 w-24 rounded-xl border border-slate-200 object-cover">
                        </div>
                    @endif

                    <input type="file"
                           name="photo"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, JPEG, PNG, WEBP — Max 2MB
                    </p>
                </div>


                {{-- NID Document --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        NID Document
                    </label>

                    @if ($client->nid_document)
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $client->nid_document) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-lg bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100">
                                <i class="bi bi-file-earmark-pdf"></i>
                                View Current NID
                            </a>
                        </div>
                    @endif

                    <input type="file"
                           name="nid_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, PNG, PDF — Max 5MB
                    </p>
                </div>


                {{-- Other Document --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Other Document
                    </label>

                    @if ($client->other_document)
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $client->other_document) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">
                                <i class="bi bi-file-earmark"></i>
                                View Current Document
                            </a>
                        </div>
                    @endif

                    <input type="file"
                           name="other_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, PNG, PDF — Max 5MB
                    </p>
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- NOMINEE INFORMATION --}}
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
                            Nominee details and contact information
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Nominee Name --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee Name
                    </label>

                    <input type="text"
                           name="nominee_name"
                           value="{{ old('nominee_name', $client->nominee_name) }}"
                           placeholder="Nominee name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Relation --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Relationship
                    </label>

                    <input type="text"
                           name="nominee_relation"
                           value="{{ old('nominee_relation', $client->nominee_relation) }}"
                           placeholder="e.g. Wife, Son, Daughter"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Nominee Phone --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee Phone
                    </label>

                    <input type="text"
                           name="nominee_phone"
                           value="{{ old('nominee_phone', $client->nominee_phone) }}"
                           placeholder="Nominee phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Nominee NID --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee NID
                    </label>

                    <input type="text"
                           name="nominee_nid"
                           value="{{ old('nominee_nid', $client->nominee_nid) }}"
                           placeholder="Nominee NID"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Nominee Address --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee Address
                    </label>

                    <textarea name="nominee_address"
                              rows="2"
                              placeholder="Nominee full address"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('nominee_address', $client->nominee_address) }}</textarea>
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
                            Existing nominee files can be replaced by uploading new files.
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Nominee Photo --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee Photo
                    </label>

                    @if ($client->nominee_photo)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $client->nominee_photo) }}"
                                 alt="Nominee Photo"
                                 class="h-24 w-24 rounded-xl border border-slate-200 object-cover">
                        </div>
                    @endif

                    <input type="file"
                           name="nominee_photo"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-orange-50 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-orange-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, JPEG, PNG, WEBP — Max 2MB
                    </p>
                </div>


                {{-- Nominee NID --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee NID Document
                    </label>

                    @if ($client->nominee_nid_document)
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $client->nominee_nid_document) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-lg bg-orange-50 px-3 py-2 text-sm font-medium text-orange-700 hover:bg-orange-100">
                                <i class="bi bi-file-earmark-pdf"></i>
                                View Current NID
                            </a>
                        </div>
                    @endif

                    <input type="file"
                           name="nominee_nid_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-orange-50 file:px-4 file:py-2.5 file:font-medium file:text-orange-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, PNG, PDF — Max 5MB
                    </p>
                </div>


                {{-- Nominee Other Document --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Nominee Other Document
                    </label>

                    @if ($client->nominee_other_document)
                        <div class="mb-3">
                            <a href="{{ asset('storage/' . $client->nominee_other_document) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">
                                <i class="bi bi-file-earmark"></i>
                                View Current Document
                            </a>
                        </div>
                    @endif

                    <input type="file"
                           name="nominee_other_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-orange-50 file:px-4 file:py-2.5 file:font-medium file:text-orange-700">

                    <p class="mt-1 text-xs text-slate-400">
                        JPG, PNG, PDF — Max 5MB
                    </p>
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- STATUS / REMARKS --}}
        {{-- ========================================================= --}}

        <div class="erp-card overflow-hidden">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-200 text-slate-600">
                        <i class="bi bi-sliders"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Status & Remarks
                        </h2>

                        <p class="text-xs text-slate-500">
                            Client status and additional notes
                        </p>
                    </div>

                </div>
            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <option value="active"
                            {{ old('status', $client->status) === 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $client->status) === 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Remarks --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              rows="3"
                              placeholder="Additional remarks"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('remarks', $client->remarks) }}</textarea>
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- ACTIONS --}}
        {{-- ========================================================= --}}

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

            <a href="{{ route('admin.clients.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                <i class="bi bi-x-lg"></i>
                Cancel
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                <i class="bi bi-check2-circle"></i>
                Update Client
            </button>

        </div>

    </form>

</div>


{{-- ========================================================= --}}
{{-- COMPANY → BRANCH → PROJECT FILTER --}}
{{-- ========================================================= --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');

    const originalBranch = @json(old('branch_id', $client->branch_id));
    const originalProject = @json(old('project_id', $client->project_id));

    function filterBranches(resetValue = false) {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const company = option.dataset.company;

            option.hidden = company !== companyId;
        });

        if (resetValue) {
            branchSelect.value = '';
        }

        const selectedBranch = branchSelect.options[branchSelect.selectedIndex];

        if (
            selectedBranch &&
            selectedBranch.value &&
            selectedBranch.hidden
        ) {
            branchSelect.value = '';
        }
    }


    function filterProjects(resetValue = false) {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            const optionCompany = option.dataset.company;
            const optionBranch = option.dataset.branch;

            option.hidden =
                optionCompany !== companyId ||
                optionBranch !== branchId;
        });

        if (resetValue) {
            projectSelect.value = '';
        }

        const selectedProject = projectSelect.options[projectSelect.selectedIndex];

        if (
            selectedProject &&
            selectedProject.value &&
            selectedProject.hidden
        ) {
            projectSelect.value = '';
        }
    }


    companySelect.addEventListener('change', function () {

        filterBranches(true);
        filterProjects(true);

    });


    branchSelect.addEventListener('change', function () {

        filterProjects(true);

    });


    /*
    |--------------------------------------------------------------------------
    | Initial Load
    |--------------------------------------------------------------------------
    */

    filterBranches(false);

    branchSelect.value = originalBranch;

    filterProjects(false);

    projectSelect.value = originalProject;

});
</script>
@endpush

@endsection 