@extends('admin.layouts.app')

@section('title', 'Add RAJUK Approval')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Add RAJUK Approval
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Create a new RAJUK plan and approval record.
            </p>
        </div>

        <a href="{{ route('admin.rajuk-approvals.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">

            <i class="bi bi-arrow-left"></i>
            Back to List

        </a>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 p-4">

            <div class="flex items-center gap-2 text-sm font-semibold text-red-700">
                <i class="bi bi-exclamation-circle"></i>
                Please fix the following errors:
            </div>

            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-600">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('admin.rajuk-approvals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- ==============   PROJECT & APPLICATION INFORMATION ==== --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-blue-50 p-2 text-blue-600">
                        <i class="bi bi-building"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Project & Application Information
                        </h2>
                        <p class="text-xs text-slate-500">
                            Select project and enter RAJUK application details.
                        </p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">
 
                {{-- Company --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="company_id"
                        id="company_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Select Company</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('company_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Branch --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="branch_id"
                        id="branch_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Select Branch</option>

                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Project --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="project_id"
                        id="project_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                            <option
                                value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ old('project_id') == $project->id ? 'selected' : '' }}
                            >
                                {{ $project->project_code }} - {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> 
 

                {{-- Application Number --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Application Number
                    </label>

                    <input type="text"
                           name="application_no"
                           value="{{ old('application_no') }}"
                           placeholder="Enter application number"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('application_no')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>
 
 



        {{-- ============================================================
             APPLICANT INFORMATION
        ============================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="rounded-lg bg-green-50 p-2 text-green-600">
                        <i class="bi bi-person"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Applicant Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Applicant contact information.
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Applicant Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Applicant Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="applicant_name"
                           value="{{ old('applicant_name') }}"
                           required
                           placeholder="Enter applicant name"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('applicant_name')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Applicant Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Applicant Phone
                    </label>

                    <input type="text"
                           name="applicant_phone"
                           value="{{ old('applicant_phone') }}"
                           placeholder="01XXXXXXXXX"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    @error('applicant_phone')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- ====================  LAND INFORMATION =========== --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                        <i class="bi bi-geo-alt"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Land Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Plot and land details related to the project.
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Plot Number --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Plot Number
                    </label>

                    <input type="text"
                           name="plot_number"
                           value="{{ old('plot_number') }}"
                           placeholder="Enter plot number"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Road Number --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Road Number
                    </label>

                    <input type="text"
                           name="road_number"
                           value="{{ old('road_number') }}"
                           placeholder="Enter road number"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Block --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Block
                    </label>

                    <input type="text"
                           name="block"
                           value="{{ old('block') }}"
                           placeholder="Enter block"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Mouza --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Mouza
                    </label>

                    <input type="text"
                           name="mouza"
                           value="{{ old('mouza') }}"
                           placeholder="Enter mouza"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Land Area --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Land Area
                    </label>

                    <input type="text"
                           name="land_area"
                           value="{{ old('land_area') }}"
                           placeholder="Example: 5 Katha"
                           class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>

            </div>

        </div>


        {{-- ============================================================
             BUILDING INFORMATION
        ============================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="rounded-lg bg-purple-50 p-2 text-purple-600">
                        <i class="bi bi-buildings"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Building Information
                        </h2>

                        <p class="text-xs text-slate-500">
                            Proposed building plan details.
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Plan Type --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Plan Type
                    </label>

                    <select name="plan_type"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <option value="">
                            Select Plan Type
                        </option>

                        <option value="Residential"
                            {{ old('plan_type') === 'Residential' ? 'selected' : '' }}>
                            Residential
                        </option>

                        <option value="Commercial"
                            {{ old('plan_type') === 'Commercial' ? 'selected' : '' }}>
                            Commercial
                        </option>

                        <option value="Residential & Commercial"
                            {{ old('plan_type') === 'Residential & Commercial' ? 'selected' : '' }}>
                            Residential & Commercial
                        </option>

                        <option value="Mixed Use"
                            {{ old('plan_type') === 'Mixed Use' ? 'selected' : '' }}>
                            Mixed Use
                        </option>

                        <option value="Other"
                            {{ old('plan_type') === 'Other' ? 'selected' : '' }}>
                            Other
                        </option>

                    </select>

                </div>


                {{-- Number of Floors --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Number of Floors
                    </label>

                    <input type="number"
                           name="number_of_floors"
                           value="{{ old('number_of_floors') }}"
                           min="1"
                           placeholder="Enter number of floors"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Number of Flats --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Number of Flats
                    </label>

                    <input type="number"
                           name="number_of_flats"
                           value="{{ old('number_of_flats') }}"
                           min="1"
                           placeholder="Enter number of flats"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Architect --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Architect Name
                    </label>

                    <input type="text"
                           name="architect_name"
                           value="{{ old('architect_name') }}"
                           placeholder="Enter architect name"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Consultant --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Consultant Name
                    </label>

                    <input type="text"
                           name="consultant_name"
                           value="{{ old('consultant_name') }}"
                           placeholder="Enter consultant name"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>

            </div>

        </div>


        {{-- ============================================================
             APPLICATION & APPROVAL DETAILS
        ============================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="rounded-lg bg-indigo-50 p-2 text-indigo-600">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Application & Approval Details
                        </h2>

                        <p class="text-xs text-slate-500">
                            Track RAJUK application and approval status.
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Application Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Application Date
                    </label>

                    <input type="date"
                           name="application_date"
                           value="{{ old('application_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Submission Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Submission Date
                    </label>

                    <input type="date"
                           name="submission_date"
                           value="{{ old('submission_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Approval Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Approval Date
                    </label>

                    <input type="date"
                           name="approval_date"
                           value="{{ old('approval_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Approval Number --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Approval Number
                    </label>

                    <input type="text"
                           name="approval_number"
                           value="{{ old('approval_number') }}"
                           placeholder="Enter approval number"
                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>


                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <option value="draft"
                            {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="submitted"
                            {{ old('status') === 'submitted' ? 'selected' : '' }}>
                            Submitted
                        </option>

                        <option value="under_review"
                            {{ old('status') === 'under_review' ? 'selected' : '' }}>
                            Under Review
                        </option>

                        <option value="approved"
                            {{ old('status') === 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ old('status') === 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                        <option value="on_hold"
                            {{ old('status') === 'on_hold' ? 'selected' : '' }}>
                            On Hold
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Remarks --}}
            <div class="px-5 pb-5">

                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Remarks
                </label>

                <textarea name="remarks"
                          rows="4"
                          placeholder="Enter additional remarks..."
                          class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('remarks') }}</textarea>

                @error('remarks')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>


        {{-- ============================================================
             DOCUMENTS
        ============================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                <div class="flex items-center gap-3">

                    <div class="rounded-lg bg-red-50 p-2 text-red-600">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-slate-800">
                            Documents
                        </h2>

                        <p class="text-xs text-slate-500">
                            Upload RAJUK plan and approval documents.
                        </p>
                    </div>

                </div>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Plan Document --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Plan Document
                    </label>

                    <input type="file"
                           name="plan_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2.5 file:font-medium file:text-blue-700 hover:file:bg-blue-100">

                    <p class="mt-1.5 text-xs text-slate-500">
                        Allowed: PDF, JPG, JPEG, PNG | Maximum: 10MB
                    </p>

                    @error('plan_document')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Approval Document --}}
                <div>

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Approval Document
                    </label>

                    <input type="file"
                           name="approval_document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-green-50 file:px-4 file:py-2.5 file:font-medium file:text-green-700 hover:file:bg-green-100">

                    <p class="mt-1.5 text-xs text-slate-500">
                        Allowed: PDF, JPG, JPEG, PNG | Maximum: 10MB
                    </p>

                    @error('approval_document')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- ============================================================
             ACTION BUTTONS
        ============================================================= --}}

        <div class="flex flex-col-reverse gap-3 rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:justify-end">

            <a href="{{ route('admin.rajuk-approvals.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                Cancel

            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                <i class="bi bi-check-circle"></i>

                Save RAJUK Approval

            </button>

        </div>

    </form>

</div>

@endsection