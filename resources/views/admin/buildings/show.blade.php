@extends('admin.layouts.app')

@section('title', 'Building Details')

@section('content')

<style>
    .building-show {
        color: #334155;
    }

    .building-show .show-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 22px;
    }

    .building-show .show-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 5px;
    }

    .building-show .show-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }

    .building-show .show-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-bottom: 20px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
    }

    .building-show .section-heading {
        padding: 15px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .building-show .section-body {
        padding: 20px;
    }

    .building-show .info-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px 20px;
    }

    .building-show .info-label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .building-show .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        overflow-wrap: anywhere;
    }

    .building-show .status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .building-show .status-planning { background: #f1f5f9; color: #475569; }
    .building-show .status-preparation { background: #e0f2fe; color: #0369a1; }
    .building-show .status-ongoing { background: #dbeafe; color: #1d4ed8; }
    .building-show .status-paused { background: #fef3c7; color: #92400e; }
    .building-show .status-completed { background: #dcfce7; color: #166534; }
    .building-show .status-on_hold { background: #fee2e2; color: #b91c1c; }

    .building-show .show-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
    }

    .building-show .show-btn-primary {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }

    .building-show .show-btn:hover {
        opacity: .88;
    }

    .building-show .document-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
    }

    .building-show .building-image {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    @media(max-width: 768px) {
        .building-show .info-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width: 480px) {
        .building-show .info-grid {
            grid-template-columns: 1fr;
        }

        .building-show .section-body {
            padding: 15px;
        }
    }
</style>

@php
    $statusLabels = [
        'planning' => 'Planning',
        'preparation' => 'Preparation',
        'ongoing' => 'Ongoing',
        'paused' => 'Paused',
        'completed' => 'Completed',
        'on_hold' => 'On Hold',
    ];
@endphp

<div class="building-show">

    {{-- Header --}}
    <div class="show-header">
        <div>
            <h4 class="show-title">Building Details</h4>
            <p class="show-subtitle">
                Complete building and construction information.
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.buildings.index') }}" class="show-btn">
                <i class="bi bi-arrow-left"></i> Back
            </a>

            <a href="{{ route('admin.buildings.edit', $building->id) }}"
               class="show-btn show-btn-primary">
                <i class="bi bi-pencil-square"></i> Edit Building
            </a>
        </div>
    </div>

    {{-- Building Overview --}}
    <div class="show-card">
        <div class="section-heading">
            <i class="bi bi-building me-2"></i> Building Overview
        </div>

        <div class="section-body">
            <div class="info-grid">

                <div>
                    <div class="info-label">Building Name</div>
                    <div class="info-value">{{ $building->building_name }}</div>
                </div>

                <div>
                    <div class="info-label">Building Code</div>
                    <div class="info-value">{{ $building->building_code ?: 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Building Type</div>
                    <div class="info-value">{{ $building->building_type ?: 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Company</div>
                    <div class="info-value">{{ $building->company->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Branch</div>
                    <div class="info-value">{{ $building->branch->name ?? 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Project</div>
                    <div class="info-value">{{ $building->project->project_name ?? 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Number of Floors</div>
                    <div class="info-value">{{ $building->number_of_floors ?? 0 }}</div>
                </div>

                <div>
                    <div class="info-label">Number of Basements</div>
                    <div class="info-value">{{ $building->number_of_basements ?? 0 }}</div>
                </div>

                <div>
                    <div class="info-label">Total Flats</div>
                    <div class="info-value">{{ $building->total_flats ?? 0 }}</div>
                </div>

                <div>
                    <div class="info-label">Current Status</div>
                    <div class="info-value">
                        <span class="status status-{{ $building->status }}">
                            {{ $statusLabels[$building->status] ?? ucfirst($building->status) }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- RAJUK Approval --}}
    <div class="show-card">
        <div class="section-heading">
            <i class="bi bi-file-earmark-check me-2"></i> RAJUK Approval
        </div>

        <div class="section-body">
            @if($building->rajukApproval)

                <div class="info-grid">

                    <div>
                        <div class="info-label">Application Number</div>
                        <div class="info-value">
                            {{ $building->rajukApproval->application_no ?: 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Approval Number</div>
                        <div class="info-value">
                            {{ $building->rajukApproval->approval_number ?: 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Approval Date</div>
                        <div class="info-value">
                            {{ $building->rajukApproval->approval_date?->format('d M Y') ?? 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Applicant Name</div>
                        <div class="info-value">
                            {{ $building->rajukApproval->applicant_name ?: 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Plan Type</div>
                        <div class="info-value">
                            {{ $building->rajukApproval->plan_type ?: 'N/A' }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">RAJUK Status</div>
                        <div class="info-value">
                            {{ ucfirst(str_replace('_', ' ', $building->rajukApproval->status)) }}
                        </div>
                    </div>

                </div>

            @else
                <p class="text-muted mb-0">
                    No RAJUK approval linked with this building.
                </p>
            @endif
        </div>
    </div>

    {{-- Construction Details --}}
    <div class="show-card">
        <div class="section-heading">
            <i class="bi bi-calendar-check me-2"></i> Construction Details
        </div>

        <div class="section-body">
            <div class="info-grid">

                <div>
                    <div class="info-label">Construction Start Date</div>
                    <div class="info-value">
                        {{ $building->construction_start_date?->format('d M Y') ?? 'N/A' }}
                    </div>
                </div>

                <div>
                    <div class="info-label">Expected Completion Date</div>
                    <div class="info-value">
                        {{ $building->expected_completion_date?->format('d M Y') ?? 'N/A' }}
                    </div>
                </div>

                <div>
                    <div class="info-label">Actual Completion Date</div>
                    <div class="info-value">
                        {{ $building->actual_completion_date?->format('d M Y') ?? 'N/A' }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Contractor & Team --}}
    <div class="show-card">
        <div class="section-heading">
            <i class="bi bi-people me-2"></i> Contractor & Technical Team
        </div>

        <div class="section-body">
            <div class="info-grid">

                <div>
                    <div class="info-label">Contractor Name</div>
                    <div class="info-value">{{ $building->contractor_name ?: 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Contractor Phone</div>
                    <div class="info-value">{{ $building->contractor_phone ?: 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Architect Name</div>
                    <div class="info-value">{{ $building->architect_name ?: 'N/A' }}</div>
                </div>

                <div>
                    <div class="info-label">Engineer Name</div>
                    <div class="info-value">{{ $building->engineer_name ?: 'N/A' }}</div>
                </div>

            </div>
        </div>
    </div>

    {{-- Documents --}}
    <div class="show-card">
        <div class="section-heading">
            <i class="bi bi-folder2-open me-2"></i> Building Documents
        </div>

        <div class="section-body">
            <div class="info-grid">

                <div>
                    <div class="info-label">Building Image</div>

                    @if($building->building_image)
                        <a href="{{ asset('storage/'.$building->building_image) }}"
                           target="_blank">
                            <img src="{{ asset('storage/'.$building->building_image) }}"
                                 class="building-image"
                                 alt="Building Image">
                        </a>
                    @else
                        <div class="info-value">No image uploaded</div>
                    @endif
                </div>

                <div>
                    <div class="info-label">Building Document</div>

                    @if($building->document)
                        <a href="{{ asset('storage/'.$building->document) }}"
                           target="_blank"
                           class="document-link">
                            <i class="bi bi-file-earmark-pdf"></i>
                            View Document
                        </a>
                    @else
                        <div class="info-value">No document uploaded</div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($building->description)
        <div class="show-card">
            <div class="section-heading">
                <i class="bi bi-card-text me-2"></i> Description
            </div>

            <div class="section-body">
                <p class="mb-0" style="white-space: pre-line;">
                    {{ $building->description }}
                </p>
            </div>
        </div>
    @endif

</div>
@endsection