@extends('admin.layouts.app')

@section('title', 'Add Client')
@section('page-title', 'Add Client')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Add Client</h1>
            <p class="text-sm text-slate-500">
                Create a new client with nominee and document information.
            </p>
        </div>

        <a href="{{ route('admin.clients.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300
                  bg-white px-4 py-2 text-sm font-medium text-slate-700
                  hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            Back to Clients
        </a>
    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <div class="flex items-start gap-3">
                <i class="bi bi-exclamation-triangle-fill mt-0.5 text-red-600"></i>

                <div>
                    <h3 class="font-semibold text-red-800">
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


    <form action="{{ route('admin.clients.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf


        {{-- Company / Branch / Project --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                        <i class="bi bi-building text-blue-600"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Business Assignment
                        </h2>

                        <p class="text-xs text-slate-500">
                            Select company, branch and project.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select name="company_id"
                            id="company_id"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                   text-sm text-slate-700 focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">
                        <option value="">Select Company</option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
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
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                   text-sm text-slate-700 focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

                        <option value="">Select Branch</option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    data-company="{{ $branch->company_id }}"
                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
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
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                   text-sm text-slate-700 focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

                        <option value="">Select Project</option>

                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
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


        {{-- Client Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                        <i class="bi bi-person text-blue-600"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Client Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Enter client's personal information.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">

                {{-- Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Client Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="Enter client name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Father --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Father's Name
                    </label>

                    <input type="text"
                           name="father_name"
                           value="{{ old('father_name') }}"
                           placeholder="Father's name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Mother --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Mother's Name
                    </label>

                    <input type="text"
                           name="mother_name"
                           value="{{ old('mother_name') }}"
                           placeholder="Mother's name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Spouse --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Spouse Name
                    </label>

                    <input type="text"
                           name="spouse_name"
                           value="{{ old('spouse_name') }}"
                           placeholder="Spouse name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Phone <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           required
                           placeholder="01XXXXXXXXX"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Alternate Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Alternate Phone
                    </label>

                    <input type="text"
                           name="alternate_phone"
                           value="{{ old('alternate_phone') }}"
                           placeholder="Alternative phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Email --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="client@example.com"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- DOB --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Date of Birth
                    </label>

                    <input type="date"
                           name="date_of_birth"
                           value="{{ old('date_of_birth') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Occupation --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Occupation
                    </label>

                    <input type="text"
                           name="occupation"
                           value="{{ old('occupation') }}"
                           placeholder="Occupation"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>

            </div>
        </div>


        {{-- NID & Address --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    NID & Address
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    National ID and permanent/current address information.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- NID --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        NID Number
                    </label>

                    <input type="text"
                           name="nid"
                           value="{{ old('nid') }}"
                           placeholder="National ID number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('nid')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- City --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        City
                    </label>

                    <input type="text"
                           name="city"
                           value="{{ old('city') }}"
                           placeholder="City"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Address
                    </label>

                    <textarea name="address"
                              rows="3"
                              placeholder="Full address"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                     focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('address') }}</textarea>
                </div>

            </div>
        </div>


        {{-- Client Documents --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Client Documents
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Upload client photo and identification documents.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Photo --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Client Photo
                    </label>

                    <input type="file"
                           name="photo"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-blue-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG, WEBP. Max 2MB.
                    </p>
                </div>


                {{-- NID Document --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        NID Document
                    </label>

                    <input type="file"
                           name="nid_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-blue-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG or PDF. Max 5MB.
                    </p>
                </div>


                {{-- Other Document --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Other Document
                    </label>

                    <input type="file"
                           name="other_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-blue-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-blue-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG or PDF. Max 5MB.
                    </p>
                </div>

            </div>
        </div>


        {{-- Nominee Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <div class="flex items-center gap-2">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-50">
                        <i class="bi bi-person-check text-green-600"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Nominee Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Enter nominee details for the client.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">

                {{-- Nominee Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee Name
                    </label>

                    <input type="text"
                           name="nominee_name"
                           value="{{ old('nominee_name') }}"
                           placeholder="Nominee name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Relation --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Relationship
                    </label>

                    <select name="nominee_relation"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                   text-sm text-slate-700 focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

                        <option value="">Select Relationship</option>

                        @foreach (['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Brother', 'Sister', 'Other'] as $relation)
                            <option value="{{ $relation }}"
                                {{ old('nominee_relation') == $relation ? 'selected' : '' }}>
                                {{ $relation }}
                            </option>
                        @endforeach

                    </select>
                </div>


                {{-- Nominee Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee Phone
                    </label>

                    <input type="text"
                           name="nominee_phone"
                           value="{{ old('nominee_phone') }}"
                           placeholder="Nominee phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Nominee NID --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee NID
                    </label>

                    <input type="text"
                           name="nominee_nid"
                           value="{{ old('nominee_nid') }}"
                           placeholder="Nominee NID number"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                  focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>


                {{-- Nominee Address --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee Address
                    </label>

                    <textarea name="nominee_address"
                              rows="2"
                              placeholder="Nominee full address"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                     focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('nominee_address') }}</textarea>
                </div>

            </div>
        </div>


        {{-- Nominee Documents --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Nominee Documents
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Upload nominee photo and identification documents.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Nominee Photo --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee Photo
                    </label>

                    <input type="file"
                           name="nominee_photo"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-green-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-green-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG, WEBP. Max 2MB.
                    </p>
                </div>


                {{-- Nominee NID --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee NID Document
                    </label>

                    <input type="file"
                           name="nominee_nid_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-green-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-green-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG or PDF. Max 5MB.
                    </p>
                </div>


                {{-- Nominee Other --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Nominee Other Document
                    </label>

                    <input type="file"
                           name="nominee_other_document"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="block w-full rounded-lg border border-slate-300 bg-white
                                  text-sm text-slate-600 file:mr-3 file:border-0
                                  file:bg-green-50 file:px-4 file:py-2.5
                                  file:text-sm file:font-medium file:text-green-700">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, PNG or PDF. Max 5MB.
                    </p>
                </div>

            </div>
        </div>


        {{-- Status / Remarks --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    Status & Remarks
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                   text-sm text-slate-700 focus:border-blue-500 focus:ring-2
                                   focus:ring-blue-100">

                        <option value="active"
                            {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>
                </div>


                {{-- Remarks --}}
                <div class="md:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Remarks
                    </label>

                    <textarea name="remarks"
                              rows="2"
                              placeholder="Additional remarks..."
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                     focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('remarks') }}</textarea>
                </div>

            </div>
        </div>


        {{-- Buttons --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.clients.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300
                      bg-white px-5 py-2.5 text-sm font-medium text-slate-700
                      hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg
                           bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white
                           shadow-sm hover:bg-blue-700">
                <i class="bi bi-person-plus"></i>
                Create Client
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

    const oldBranch = @json(old('branch_id'));
    const oldProject = @json(old('project_id'));

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
                option.dataset.company === companyId;

            const matchesBranch =
                option.dataset.branch === branchId;

            option.hidden = !(matchesCompany && matchesBranch);
        });

        if (
            projectSelect.value &&
            (
                projectSelect.selectedOptions[0]?.dataset.company !== companyId ||
                projectSelect.selectedOptions[0]?.dataset.branch !== branchId
            )
        ) {
            projectSelect.value = '';
        }
    }


    companySelect.addEventListener('change', function () {

        filterBranches();

    });


    branchSelect.addEventListener('change', function () {

        filterProjects();

    });


    // Initial filtering
    filterBranches();


    // Restore old values after validation error
    if (oldBranch) {
        branchSelect.value = oldBranch;
        filterProjects();
    }

    if (oldProject) {
        projectSelect.value = oldProject;
    }

});
</script>
@endpush 
