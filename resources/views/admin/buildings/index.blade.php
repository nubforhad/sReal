@extends('admin.layouts.app')

@section('title', 'Building List')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Building Management</h4>
            <p class="text-muted mb-0">Manage all buildings and construction information.</p>
        </div>
        <a href="{{ route('admin.buildings.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Building
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Search & Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.buildings.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Search Building</label>
                        <input type="text" name="search" class="form-control" placeholder="Building name, code, contractor..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Company</label>
                        <select name="company_id" class="form-select">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Branch</label>
                        <select name="branch_id" class="form-select">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                    {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->project_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            @foreach([
                                'planning' => 'Planning',
                                'preparation' => 'Preparation',
                                'ongoing' => 'Ongoing',
                                'paused' => 'Paused',
                                'completed' => 'Completed',
                                'on_hold' => 'On Hold'
                            ] as $value => $label)
                                <option value="{{ $value }}"
                                    {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-12">
                        <a href="{{ route('admin.buildings.index') }}"
                           class="btn btn-sm btn-light border">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Building Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Building List</h5>
            <span class="badge bg-secondary">
                Total: {{ $buildings->total() }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Building</th>
                            <th>Company / Branch</th>
                            <th>Project</th>
                            <th>Floors / Flats</th>
                            <th>Construction Period</th>
                            <th>Status</th>
                            <th width="150" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($buildings as $building)
                            <tr>
                                <td>
                                    {{ $buildings->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $building->building_name }}
                                    </div>

                                    <small class="text-muted">
                                        Code: {{ $building->building_code ?: 'N/A' }}
                                    </small>
                                </td>

                                <td>
                                    <div>{{ $building->company->name ?? 'N/A' }}</div>
                                    <small class="text-muted">
                                        {{ $building->branch->name ?? 'N/A' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $building->project->project_name ?? 'N/A' }}
                                </td>

                                <td>
                                    <div>
                                        Floors:
                                        <strong>{{ $building->number_of_floors ?? 0 }}</strong>
                                    </div>
                                    <small class="text-muted">
                                        Flats: {{ $building->total_flats ?? 0 }}
                                    </small>
                                </td>

                                <td>
                                    <div>
                                        Start:
                                        {{ $building->construction_start_date?->format('d M Y') ?? 'N/A' }}
                                    </div>
                                    <small class="text-muted">
                                        Expected:
                                        {{ $building->expected_completion_date?->format('d M Y') ?? 'N/A' }}
                                    </small>
                                </td>

                                <td>
                                    @php
                                        $statusClasses = [
                                            'planning' => 'bg-secondary',
                                            'preparation' => 'bg-info text-dark',
                                            'ongoing' => 'bg-primary',
                                            'paused' => 'bg-warning text-dark',
                                            'completed' => 'bg-success',
                                            'on_hold' => 'bg-danger',
                                        ];

                                        $statusLabels = [
                                            'planning' => 'Planning',
                                            'preparation' => 'Preparation',
                                            'ongoing' => 'Ongoing',
                                            'paused' => 'Paused',
                                            'completed' => 'Completed',
                                            'on_hold' => 'On Hold',
                                        ];
                                    @endphp

                                    <span class="badge {{ $statusClasses[$building->status] ?? 'bg-secondary' }}">
                                        {{ $statusLabels[$building->status] ?? ucfirst($building->status) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-1">

                                        <a href="{{ route('admin.buildings.show', $building->id) }}"
                                           class="btn btn-sm btn-outline-info"
                                           title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.buildings.destroy', $building->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this building?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-building fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        No building records found.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($buildings->hasPages())
            <div class="card-footer bg-white">
                {{ $buildings->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
