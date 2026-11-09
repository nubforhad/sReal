@extends('admin.layouts.app')

@section('title', 'Edit Building')

@section('content')

<style>
    .building-edit {
        color: #334155;
    }

    .building-edit .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .building-edit .edit-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .building-edit .edit-subtitle {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .building-edit .edit-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .building-edit .edit-card-header {
        padding: 15px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .building-edit .edit-card-body {
        padding: 20px;
    }

    .building-edit .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
    }

    .building-edit .form-control,
    .building-edit .form-select {
        width: 100%;
        min-height: 40px;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 13px;
        color: #334155;
        background-color: #fff;
        outline: none;
    }

    .building-edit .form-control:focus,
    .building-edit .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .building-edit textarea.form-control {
        min-height: 100px;
        resize: vertical;
    }

    .building-edit .edit-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .building-edit .edit-field {
        min-width: 0;
    }

    .building-edit .edit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 17px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .building-edit .edit-btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .building-edit .edit-btn-primary:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .building-edit .edit-btn-light {
        background: #fff;
        color: #475569;
        border-color: #cbd5e1;
    }

    .building-edit .current-file {
        margin-top: 10px;
        padding: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 12px;
    }

    .building-edit .current-file a {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
    }

    .building-edit .form-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 5px;
    }

    @media(max-width: 900px) {
        .building-edit .edit-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 550px) {
        .building-edit .edit-grid {
            grid-template-columns: 1fr;
        }

        .building-edit .edit-card-body {
            padding: 15px;
        }
    }
</style>

<div class="building-edit">

    {{-- Header --}}
    <div class="edit-header">
        <div>
            <h4 class="edit-title">Edit Building</h4>
            <p class="edit-subtitle">
                Update building and construction information.
            </p>
        </div>

        <a href="{{ route('admin.buildings.index') }}"
           class="edit-btn edit-btn-light">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buildings.update', $building->id) }}"  method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- Project Information --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <i class="bi bi-diagram-3 me-2"></i>
                Company, Branch & Project
            </div>

            <div class="edit-card-body">
                <div class="edit-grid">
                    <div class="edit-field">
                        <label class="form-label">Company <span class="text-danger">*</span></label>
                        <select name="company_id" id="company_id" class="form-select" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    @selected(old('company_id', $building->company_id) == $company->id)>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Branch <span class="text-danger">*</span></label>
                        <select name="branch_id" id="branch_id" class="form-select" required>
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    @selected(old('branch_id', $building->branch_id) == $branch->id)>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Project <span class="text-danger">*</span></label>
                        <select name="project_id" id="project_id" class="form-select" required>
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    data-company="{{ $project->company_id }}"
                                    data-branch="{{ $project->branch_id }}"
                                    @selected(old('project_id', $building->project_id) == $project->id)>
                                    {{ $project->project_code }} - {{ $project->project_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="edit-field">
                        <label class="form-label">RAJUK Approval</label>
                        <select name="rajuk_approval_id" id="rajuk_approval_id" class="form-select">
                            <option value="">Select RAJUK Approval</option>
                            @foreach($rajukApprovals as $approval)
                                <option value="{{ $approval->id }}"
                                    data-company="{{ $approval->company_id }}"
                                    data-branch="{{ $approval->branch_id }}"
                                    data-project="{{ $approval->project_id }}"
                                    @selected(old('rajuk_approval_id', $building->rajuk_approval_id) == $approval->id)>
                                    {{ $approval->application_no ?: 'Application #'.$approval->id }}
                                    - {{ $approval->applicant_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- Building Information --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <i class="bi bi-building me-2"></i>
                Building Information
            </div>

            <div class="edit-card-body">
                <div class="edit-grid">
                    <div class="edit-field">
                        <label class="form-label">Building Code</label>
                        <input type="text"  name="building_code"
                               class="form-control"
                               value="{{ old('building_code', $building->building_code) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Building Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="building_name"
                               class="form-control"
                               value="{{ old('building_name', $building->building_name) }}"
                               required>
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Building Type</label>
                        <select name="building_type" class="form-select">
                            <option value="">Select Type</option>
                            @foreach(['Residential', 'Commercial', 'Mixed Use'] as $type)
                                <option value="{{ $type }}"
                                    @selected(old('building_type', $building->building_type) == $type)>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="edit-field">
                        <label class="form-label">Number of Floors</label>
                        <input type="number" name="number_of_floors" class="form-control" min="0" value="{{ old('number_of_floors', $building->number_of_floors) }}">
                    </div>
                    <div class="edit-field">
                        <label class="form-label">Number of Basements</label>
                        <input type="number"
                               name="number_of_basements"
                               class="form-control"
                               min="0"
                               value="{{ old('number_of_basements', $building->number_of_basements ?? 0) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Total Flats</label>
                        <input type="number"
                               name="total_flats"
                               class="form-control"
                               min="0"
                               value="{{ old('total_flats', $building->total_flats) }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- Construction Dates --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <i class="bi bi-calendar-check me-2"></i>
                Construction Details
            </div>

            <div class="edit-card-body">
                <div class="edit-grid">

                    <div class="edit-field">
                        <label class="form-label">Construction Start Date</label>
                        <input type="date" name="construction_start_date"  class="form-control" value="{{ old('construction_start_date', $building->construction_start_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Expected Completion Date</label>
                        <input type="date" name="expected_completion_date" class="form-control" value="{{ old('expected_completion_date', $building->expected_completion_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Actual Completion Date</label>
                        <input type="date" name="actual_completion_date" class="form-control" value="{{ old('actual_completion_date', $building->actual_completion_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Building Status</label>
                        <select name="status" class="form-select" required>
                            @foreach([
                                'planning' => 'Planning',
                                'preparation' => 'Preparation',
                                'ongoing' => 'Ongoing',
                                'paused' => 'Paused',
                                'completed' => 'Completed',
                                'on_hold' => 'On Hold',
                            ] as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(old('status', $building->status) == $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>

        {{-- Contractor Information --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <i class="bi bi-people me-2"></i>
                Contractor & Technical Team
            </div>

            <div class="edit-card-body">
                <div class="edit-grid">

                    <div class="edit-field">
                        <label class="form-label">Contractor Name</label>
                        <input type="text"
                               name="contractor_name"
                               class="form-control"
                               value="{{ old('contractor_name', $building->contractor_name) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Contractor Phone</label>
                        <input type="text"
                               name="contractor_phone"
                               class="form-control"
                               value="{{ old('contractor_phone', $building->contractor_phone) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Architect Name</label>
                        <input type="text"
                               name="architect_name"
                               class="form-control"
                               value="{{ old('architect_name', $building->architect_name) }}">
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Engineer Name</label>
                        <input type="text"
                               name="engineer_name"
                               class="form-control"
                               value="{{ old('engineer_name', $building->engineer_name) }}">
                    </div>

                </div>
            </div>
        </div>

        {{-- Documents --}}
        <div class="edit-card">
            <div class="edit-card-header">
                <i class="bi bi-folder2-open me-2"></i>
                Building Documents
            </div>

            <div class="edit-card-body">
                <div class="edit-grid">

                    <div class="edit-field">
                        <label class="form-label">Building Image</label>
                        <input type="file"
                               name="building_image"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp">

                        @if($building->building_image)
                            <div class="current-file">
                                Current Image:
                                <a href="{{ asset('storage/'.$building->building_image) }}"
                                   target="_blank">
                                    View Image
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="edit-field">
                        <label class="form-label">Building Document</label>
                        <input type="file"
                               name="document"
                               class="form-control"
                               accept=".pdf,.jpg,.jpeg,.png">

                        @if($building->document)
                            <div class="current-file">
                                Current Document:
                                <a href="{{ asset('storage/'.$building->document) }}"
                                   target="_blank">
                                    View Document
                                </a>
                            </div>
                        @endif
                    </div>

                </div>

                <div class="mt-4">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              placeholder="Enter building description...">{{ old('description', $building->description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end flex-wrap gap-2 mb-4">

            <a href="{{ route('admin.buildings.index') }}"
               class="edit-btn edit-btn-light">
                Cancel
            </a>

            <button type="submit" class="edit-btn edit-btn-primary">
                <i class="bi bi-check-circle"></i>
                Update Building
            </button>

        </div>

    </form>

</div>

{{-- Project and RAJUK Filtering --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');
    const rajukSelect = document.getElementById('rajuk_approval_id');

    const initialProject = @json(old('project_id', $building->project_id));
    const initialRajuk = @json(old('rajuk_approval_id', $building->rajuk_approval_id));

    function filterProjects() {
        const company = companySelect.value;
        const branch = branchSelect.value;

        Array.from(projectSelect.options).forEach(option => {
            if (!option.value) return;

            const matches =
                option.dataset.company === company &&
                option.dataset.branch === branch;

            option.hidden = !matches;
            option.disabled = !matches;
        });

        const selected = projectSelect.selectedOptions[0];

        if (selected && selected.disabled) {
            projectSelect.value = '';
        }

        filterRajuk();
    }

    function filterRajuk() {
        const company = companySelect.value;
        const branch = branchSelect.value;
        const project = projectSelect.value;

        Array.from(rajukSelect.options).forEach(option => {
            if (!option.value) return;

            const matches =
                option.dataset.company === company &&
                option.dataset.branch === branch &&
                option.dataset.project === project;

            option.hidden = !matches;
            option.disabled = !matches;
        });

        const selected = rajukSelect.selectedOptions[0];

        if (selected && selected.disabled) {
            rajukSelect.value = '';
        }
    }

    companySelect.addEventListener('change', filterProjects);
    branchSelect.addEventListener('change', filterProjects);
    projectSelect.addEventListener('change', filterRajuk);

    filterProjects();

    if (initialProject) {
        projectSelect.value = initialProject;
    }

    if (initialRajuk) {
        rajukSelect.value = initialRajuk;
    }

    filterRajuk();
});
</script>

@endsection
