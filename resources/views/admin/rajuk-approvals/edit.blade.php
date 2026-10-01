@extends('admin.layouts.app')

@section('title', 'Edit RAJUK Approval')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit RAJUK Approval
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Update project-wise RAJUK plan and approval information.
            </p>
        </div>

        <a href="{{ route('admin.rajuk-approvals.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <i class="bi bi-arrow-left"></i>

            Back to List

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3">

            <div class="flex items-start gap-3">

                <i class="bi bi-exclamation-triangle-fill mt-0.5 text-red-600"></i>

                <div>

                    <p class="font-semibold text-red-700">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Form --}}
    <form
        action="{{ route('admin.rajuk-approvals.update', $rajukApproval->id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- Company Branch Project --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="flex items-center gap-2 font-semibold text-slate-800">

                    <i class="bi bi-building text-blue-600"></i>

                    Company, Branch & Project

                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                {{-- Company --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="company_id"
                        id="company_id"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Select Company
                        </option>

                        @foreach($companies as $company)

                            <option
                                value="{{ $company->id }}"
                                {{ old('company_id', $rajukApproval->company_id) == $company->id ? 'selected' : '' }}
                            >
                                {{ $company->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('company_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
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
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Select Branch
                        </option>

                        @foreach($branches as $branch)

                            <option
                                value="{{ $branch->id }}"
                                {{ old('branch_id', $rajukApproval->branch_id) == $branch->id ? 'selected' : '' }}
                            >
                                {{ $branch->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('branch_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
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
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Select Project
                        </option>

                        @foreach($projects as $project)

                            <option
                                value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                            >
                                {{ $project->project_code }} - {{ $project->project_name }}
                            </option>

                        @endforeach

                    </select>

                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Application Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-file-earmark-text mr-2 text-blue-600"></i>
                    Application Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                {{-- Application No --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Application No.
                    </label>

                    <input
                        type="text"
                        name="application_no"
                        value="{{ old('application_no', $rajukApproval->application_no) }}"
                        placeholder="Enter application number"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Applicant --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Applicant Name <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="applicant_name"
                        value="{{ old('applicant_name', $rajukApproval->applicant_name) }}"
                        required
                        placeholder="Applicant name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Phone --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Applicant Phone
                    </label>

                    <input
                        type="text"
                        name="applicant_phone"
                        value="{{ old('applicant_phone', $rajukApproval->applicant_phone) }}"
                        placeholder="01XXXXXXXXX"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>

        </div>


        {{-- Land Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-map mr-2 text-blue-600"></i>
                    Land Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Plot --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Plot Number
                    </label>

                    <input
                        type="text"
                        name="plot_number"
                        value="{{ old('plot_number', $rajukApproval->plot_number) }}"
                        placeholder="Plot number"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Road --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Road Number
                    </label>

                    <input
                        type="text"
                        name="road_number"
                        value="{{ old('road_number', $rajukApproval->road_number) }}"
                        placeholder="Road number"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Block --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Block
                    </label>

                    <input
                        type="text"
                        name="block"
                        value="{{ old('block', $rajukApproval->block) }}"
                        placeholder="Block"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Mouza --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Mouza
                    </label>

                    <input
                        type="text"
                        name="mouza"
                        value="{{ old('mouza', $rajukApproval->mouza) }}"
                        placeholder="Mouza"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Land Area --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Land Area
                    </label>

                    <input
                        type="text"
                        name="land_area"
                        value="{{ old('land_area', $rajukApproval->land_area) }}"
                        placeholder="e.g. 5 Katha"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>

        </div>


        {{-- Building Information --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-building mr-2 text-blue-600"></i>
                    Building Information
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Plan Type --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Plan Type
                    </label>

                    <input
                        type="text"
                        name="plan_type"
                        value="{{ old('plan_type', $rajukApproval->plan_type) }}"
                        placeholder="Residential / Commercial"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Floors --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Number of Floors
                    </label>

                    <input
                        type="number"
                        name="number_of_floors"
                        value="{{ old('number_of_floors', $rajukApproval->number_of_floors) }}"
                        min="1"
                        placeholder="Number of floors"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Flats --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Number of Flats
                    </label>

                    <input
                        type="number"
                        name="number_of_flats"
                        value="{{ old('number_of_flats', $rajukApproval->number_of_flats) }}"
                        min="1"
                        placeholder="Number of flats"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Architect --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Architect Name
                    </label>

                    <input
                        type="text"
                        name="architect_name"
                        value="{{ old('architect_name', $rajukApproval->architect_name) }}"
                        placeholder="Architect name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Consultant --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Consultant Name
                    </label>

                    <input
                        type="text"
                        name="consultant_name"
                        value="{{ old('consultant_name', $rajukApproval->consultant_name) }}"
                        placeholder="Consultant name"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>

            </div>

        </div>


        {{-- Application Approval Details --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-calendar-event mr-2 text-blue-600"></i>
                    Application & Approval Details
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-5 p-5 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Application Date --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Application Date
                    </label>

                    <input
                        type="date"
                        name="application_date"
                        value="{{ old('application_date', $rajukApproval->application_date?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Submission Date --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Submission Date
                    </label>

                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date', $rajukApproval->submission_date?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Approval Date --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Approval Date
                    </label>

                    <input
                        type="date"
                        name="approval_date"
                        value="{{ old('approval_date', $rajukApproval->approval_date?->format('Y-m-d')) }}"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Approval Number --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Approval Number
                    </label>

                    <input
                        type="text"
                        name="approval_number"
                        value="{{ old('approval_number', $rajukApproval->approval_number) }}"
                        placeholder="Approval number"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Status <span class="text-red-500">*</span>
                    </label>

                    <select
                        name="status"
                        required
                        class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

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
                                {{ old('status', $rajukApproval->status) === $value ? 'selected' : '' }}
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>


        {{-- Remarks --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-chat-left-text mr-2 text-blue-600"></i>
                    Remarks
                </h2>

            </div>

            <div class="p-5">

                <textarea
                    name="remarks"
                    rows="4"
                    placeholder="Write remarks..."
                    class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >{{ old('remarks', $rajukApproval->remarks) }}</textarea>

            </div>

        </div>


        {{-- Documents --}}
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-paperclip mr-2 text-blue-600"></i>
                    Documents
                </h2>

            </div>


            <div class="grid grid-cols-1 gap-6 p-5 md:grid-cols-2">

                {{-- Plan Document --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Plan Document
                    </label>


                    @if($rajukApproval->plan_document)

                        <div class="mb-3 flex items-center justify-between rounded-lg border border-blue-200 bg-blue-50 px-4 py-3">

                            <div class="flex items-center gap-2 text-sm text-blue-700">

                                <i class="bi bi-file-earmark-text"></i>

                                Existing Plan Document

                            </div>

                            <a
                                href="{{ asset('storage/' . $rajukApproval->plan_document) }}"
                                target="_blank"
                                class="text-sm font-semibold text-blue-600 hover:underline"
                            >
                                View
                            </a>

                        </div>

                    @endif


                    <input
                        type="file"
                        name="plan_document"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-slate-700 hover:file:bg-slate-200"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Leave empty to keep the existing document.
                    </p>

                </div>


                {{-- Approval Document --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Approval Document
                    </label>


                    @if($rajukApproval->approval_document)

                        <div class="mb-3 flex items-center justify-between rounded-lg border border-green-200 bg-green-50 px-4 py-3">

                            <div class="flex items-center gap-2 text-sm text-green-700">

                                <i class="bi bi-file-earmark-check"></i>

                                Existing Approval Document

                            </div>

                            <a
                                href="{{ asset('storage/' . $rajukApproval->approval_document) }}"
                                target="_blank"
                                class="text-sm font-semibold text-green-600 hover:underline"
                            >
                                View
                            </a>

                        </div>

                    @endif


                    <input
                        type="file"
                        name="approval_document"
                        accept=".pdf,.jpg,.jpeg,.png"
                        class="block w-full rounded-lg border border-slate-300 bg-white text-sm text-slate-600 file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5 file:font-semibold file:text-slate-700 hover:file:bg-slate-200"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Leave empty to keep the existing document.
                    </p>

                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a
                href="{{ route('admin.rajuk-approvals.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >

                <i class="bi bi-x-lg"></i>

                Cancel

            </a>


            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700"
            >

                <i class="bi bi-check-lg"></i>

                Update RAJUK Approval

            </button>

        </div>

    </form>

</div>


{{-- Project Filter --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');

    const originalProjectId = "{{ old('project_id', $rajukApproval->project_id) }}";

    function filterProjects(resetProject = false) {

        const companyId = companySelect.value;
        const branchId = branchSelect.value;

        const options = projectSelect.querySelectorAll(
            'option[data-company]'
        );

        options.forEach(function (option) {

            const matches =
                option.dataset.company === companyId &&
                option.dataset.branch === branchId;

            option.hidden = !matches;

        });


        if (resetProject) {

            projectSelect.value = '';

            return;
        }


        const selectedOption = projectSelect.querySelector(
            'option[value="' + originalProjectId + '"]'
        );


        if (
            selectedOption &&
            selectedOption.dataset.company === companyId &&
            selectedOption.dataset.branch === branchId
        ) {

            projectSelect.value = originalProjectId;

        } else {

            projectSelect.value = '';

        }

    }


    companySelect.addEventListener('change', function () {

        filterProjects(true);

    });


    branchSelect.addEventListener('change', function () {

        filterProjects(true);

    });


    filterProjects(false);

});
</script>

@endsection 
