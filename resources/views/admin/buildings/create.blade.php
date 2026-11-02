@extends('admin.layouts.app')

@section('title', 'Create Building')

@section('content')

<div class="mx-auto max-w-7xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Create Building</h1>
            <p class="mt-1 text-sm text-slate-500">
                Add new building construction information
            </p>
        </div>
        <a href="{{ route('admin.buildings.index') }}"
           class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            <i class="bi bi-arrow-left mr-1"></i> Back
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="mb-2 font-semibold">Please correct the following errors:</p>
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buildings.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        {{-- Company / Branch / Project --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-building mr-2"></i>
                    Company, Branch & Project
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">
                {{-- Company --}}
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select name="company_id" id="company_id" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
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
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Branch <span class="text-red-500">*</span>
                    </label>
                    <select name="branch_id" id="branch_id" required class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Branch</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
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
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Project <span class="text-red-500">*</span>
                    </label>

                    <select name="project_id" id="project_id" required  class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_code }} - {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- RAJUK Approval --}}
                <div class="md:col-span-2 lg:col-span-3">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        RAJUK Approval
                    </label>

                    <select name="rajuk_approval_id" id="rajuk_approval_id"  class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select RAJUK Approval (Optional)</option>
                        @foreach($rajukApprovals as $approval)
                            <option value="{{ $approval->id }}"
                                data-company="{{ $approval->company_id }}"
                                data-branch="{{ $approval->branch_id }}"
                                data-project="{{ $approval->project_id }}"
                                {{ old('rajuk_approval_id') == $approval->id ? 'selected' : '' }}>
                                {{ $approval->application_no ?: 'Application #' . $approval->id }}
                                - {{ $approval->applicant_name }}
                            </option>
                        @endforeach
                    </select>

                    <p class="mt-1 text-xs text-slate-500">
                        Select the approved RAJUK plan related to this project.
                    </p>

                    @error('rajuk_approval_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Building Information --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-buildings mr-2"></i>
                    Building Information
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Building Code
                    </label>
                    <input type="text" name="building_code"
                           value="{{ old('building_code') }}"
                           placeholder="e.g. BLD-001"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                    @error('building_code')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Building Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="building_name" required value="{{ old('building_name') }}" placeholder="Enter building name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('building_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Building Type
                    </label>

                    <select name="building_type"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">

                        <option value="">Select Type</option>

                        <option value="Residential" {{ old('building_type') == 'Residential' ? 'selected' : '' }}>
                            Residential
                        </option>

                        <option value="Commercial" {{ old('building_type') == 'Commercial' ? 'selected' : '' }}>
                            Commercial
                        </option>

                        <option value="Mixed Use" {{ old('building_type') == 'Mixed Use' ? 'selected' : '' }}>
                            Mixed Use
                        </option>

                    </select>

                    @error('building_type')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Number of Floors
                    </label>

                    <input type="number" name="number_of_floors"
                           min="1" value="{{ old('number_of_floors') }}"
                           placeholder="e.g. 10"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('number_of_floors')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Number of Basements
                    </label>

                    <input type="number" name="number_of_basements"
                           min="0" value="{{ old('number_of_basements', 0) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('number_of_basements')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Total Flats
                    </label>

                    <input type="number" name="total_flats"
                           min="0" value="{{ old('total_flats') }}"
                           placeholder="e.g. 40"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('total_flats')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Construction Schedule --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-calendar-event mr-2"></i>
                    Construction Schedule
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-3">

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Construction Start Date
                    </label>

                    <input type="date" name="construction_start_date"
                           value="{{ old('construction_start_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('construction_start_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Expected Completion Date
                    </label>

                    <input type="date" name="expected_completion_date"
                           value="{{ old('expected_completion_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('expected_completion_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Actual Completion Date
                    </label>

                    <input type="date" name="actual_completion_date"
                           value="{{ old('actual_completion_date') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('actual_completion_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Contractor & Engineer --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-person-workspace mr-2"></i>
                    Contractor & Engineer Information
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2 lg:grid-cols-4">

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Contractor Name
                    </label>

                    <input type="text" name="contractor_name"
                           value="{{ old('contractor_name') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('contractor_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Contractor Phone
                    </label>

                    <input type="text" name="contractor_phone"
                           value="{{ old('contractor_phone') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('contractor_phone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Architect Name
                    </label>

                    <input type="text" name="architect_name"
                           value="{{ old('architect_name') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('architect_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Engineer Name
                    </label>

                    <input type="text" name="engineer_name"
                           value="{{ old('engineer_name') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm">

                    @error('engineer_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Status & Documents --}}
        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="font-semibold text-slate-800">
                    <i class="bi bi-gear mr-2"></i>
                    Status & Documents
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-5 md:grid-cols-2">

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Construction Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status" required
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">

                        <option value="planning" {{ old('status', 'planning') == 'planning' ? 'selected' : '' }}>
                            Planning
                        </option>

                        <option value="preparation" {{ old('status') == 'preparation' ? 'selected' : '' }}>
                            Preparation
                        </option>

                        <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>
                            Ongoing
                        </option>

                        <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>
                            Paused
                        </option>

                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>
                            On Hold
                        </option>

                    </select>

                    @error('status')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Building Image
                    </label>

                    <input type="file" name="building_image"
                           accept=".jpg,.jpeg,.png,.webp"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        JPG, JPEG, PNG, WEBP (Maximum 5 MB)
                    </p>

                    @error('building_image')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Building Document
                    </label>

                    <input type="file" name="document"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        PDF, JPG, JPEG, PNG (Maximum 10 MB)
                    </p>

                    @error('document')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        Description
                    </label>

                    <textarea name="description" rows="4"
                              placeholder="Enter construction details..."
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="flex flex-col-reverse justify-end gap-3 sm:flex-row">

            <a href="{{ route('admin.buildings.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-circle mr-1"></i>
                Save Building
            </button>

        </div>

    </form>

</div>

{{-- Dependent Dropdown --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const company = document.getElementById('company_id');
    const branch = document.getElementById('branch_id');
    const project = document.getElementById('project_id');
    const approval = document.getElementById('rajuk_approval_id');

    const oldBranch = @json(old('branch_id'));
    const oldProject = @json(old('project_id'));
    const oldApproval = @json(old('rajuk_approval_id'));

    function filterProjects() {
        const companyId = company.value;
        const branchId = branch.value;

        Array.from(project.options).forEach(option => {
            if (!option.value) return;

            const match =
                option.dataset.company === companyId &&
                option.dataset.branch === branchId;

            option.hidden = !match;
            option.disabled = !match;
        });

        if (project.selectedOptions.length &&
            project.selectedOptions[0].disabled) {
            project.value = '';
        }

        filterApprovals();
    }

    function filterApprovals() {
        const companyId = company.value;
        const branchId = branch.value;
        const projectId = project.value;

        Array.from(approval.options).forEach(option => {
            if (!option.value) return;

            const match =
                option.dataset.company === companyId &&
                option.dataset.branch === branchId &&
                option.dataset.project === projectId;

            option.hidden = !match;
            option.disabled = !match;
        });

        if (approval.selectedOptions.length &&
            approval.selectedOptions[0].disabled) {
            approval.value = '';
        }
    }

    company.addEventListener('change', function () {
        project.value = '';
        approval.value = '';
        filterProjects();
    });

    branch.addEventListener('change', function () {
        project.value = '';
        approval.value = '';
        filterProjects();
    });

    project.addEventListener('change', function () {
        approval.value = '';
        filterApprovals();
    });

    // Restore old values after validation failure
    if (oldBranch) {
        branch.value = oldBranch;
    }

    filterProjects();

    if (oldProject) {
        project.value = oldProject;
        filterApprovals();
    }

    if (oldApproval) {
        approval.value = oldApproval;
    }

});
</script>

@endsection
