@extends('admin.layouts.app')

@section('title', 'Building List')

@section('content')

<style>
    .building-page {
        width: 100%;
        color: #334155;
    }

    .building-page * {
        box-sizing: border-box;
    }

    .building-page .building-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .building-page .building-title {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 5px;
    }

    .building-page .building-subtitle {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .building-page .building-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .04);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .building-page .building-card-body {
        padding: 20px;
    }

    .building-page .building-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 7px;
    }

    .building-page .building-control {
        display: block;
        width: 100%;
        height: 40px;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background-color: #fff;
        color: #334155;
        font-size: 13px;
        outline: none;
    }

    .building-page .building-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .building-page .building-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        min-height: 38px;
        padding: 8px 14px;
        border-radius: 6px;
        border: 1px solid transparent;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
    }

    .building-page .building-btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .building-page .building-btn-primary:hover {
        background: #1d4ed8;
        color: #fff;
    }

    .building-page .building-btn-light {
        background: #fff;
        border-color: #cbd5e1;
        color: #475569;
    }

    .building-page .building-btn-light:hover {
        background: #f8fafc;
    }

    .building-page .building-filter-grid {
        display: grid;
        grid-template-columns: 2fr 1.2fr 1.2fr 1.4fr 1.2fr auto;
        gap: 14px;
        align-items: end;
    }

    .building-page .building-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 17px 20px;
        border-bottom: 1px solid #e2e8f0;
        gap: 10px;
    }

    .building-page .building-table-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .building-page .building-total {
        background: #f1f5f9;
        color: #475569;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .building-page .building-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .building-page .building-table {
        width: 100%;
        min-width: 1050px;
        border-collapse: collapse;
        margin: 0;
    }

    .building-page .building-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 13px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .building-page .building-table td {
        padding: 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        vertical-align: middle;
    }

    .building-page .building-table tbody tr:hover {
        background: #f8fafc;
    }

    .building-page .building-name {
        color: #0f172a;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .building-page .building-muted {
        color: #64748b;
        font-size: 12px;
    }

    .building-page .building-status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .building-page .status-planning {
        background: #f1f5f9;
        color: #475569;
    }

    .building-page .status-preparation {
        background: #e0f2fe;
        color: #0369a1;
    }

    .building-page .status-ongoing {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .building-page .status-paused {
        background: #fef3c7;
        color: #92400e;
    }

    .building-page .status-completed {
        background: #dcfce7;
        color: #166534;
    }

    .building-page .status-on_hold {
        background: #fee2e2;
        color: #b91c1c;
    }

    .building-page .building-actions {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .building-page .building-action {
        display: inline-flex;
        width: 31px;
        height: 31px;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        text-decoration: none;
        border: 1px solid;
        background: #fff;
        cursor: pointer;
    }

    .building-page .action-view {
        color: #0891b2;
        border-color: #a5f3fc;
    }

    .building-page .action-edit {
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .building-page .action-delete {
        color: #dc2626;
        border-color: #fecaca;
    }

    .building-page .building-empty {
        padding: 55px 15px;
        text-align: center;
        color: #64748b;
    }

    .building-page .building-empty i {
        font-size: 35px;
        display: block;
        margin-bottom: 10px;
    }

    .building-page .building-pagination {
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
    }

    .building-page .building-pagination nav {
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 1100px) {
        .building-page .building-filter-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 650px) {
        .building-page .building-header {
            align-items: flex-start;
        }

        .building-page .building-title {
            font-size: 19px;
        }

        .building-page .building-card-body {
            padding: 14px;
        }

        .building-page .building-filter-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .building-page .building-filter-grid .filter-search {
            grid-column: 1 / -1;
        }

        .building-page .building-table-header {
            padding: 14px;
        }
    }

    @media (max-width: 380px) {
        .building-page .building-filter-grid {
            grid-template-columns: 1fr;
        }

        .building-page .building-filter-grid .filter-search {
            grid-column: auto;
        }
    }
</style>

<div class="building-page">

    {{-- Header --}}
    <div class="building-header">
        <div>
            <h4 class="building-title">Building Management</h4>
            <p class="building-subtitle">
                Manage all buildings and construction information.
            </p>
        </div>

        <a href="{{ route('admin.buildings.create') }}" class="building-btn building-btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add Building
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    {{-- Filters --}}
    <div class="building-card">
        <div class="building-card-body">

            <form action="{{ route('admin.buildings.index') }}" method="GET">

                <div class="building-filter-grid">

                    <div class="filter-search">
                        <label class="building-label">Search Building</label>
                        <input type="text" name="search" class="building-control"
                            placeholder="Building name, code, contractor..." value="{{ request('search') }}">
                    </div>

                    <div>
                        <label class="building-label">Company</label>
                        <select name="company_id" class="building-control">
                            <option value="">All Companies</option>
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}" @selected(request('company_id')==$company->id)>
                                {{ $company->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="building-label">Branch</label>
                        <select name="branch_id" class="building-control">
                            <option value="">All Branches</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" @selected(request('branch_id')==$branch->id)>
                                {{ $branch->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="building-label">Project</label>
                        <select name="project_id" class="building-control">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}" @selected(request('project_id')==$project->id)>
                                {{ $project->project_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="building-label">Status</label>
                        <select name="status" class="building-control">
                            <option value="">All Status</option>
                            @foreach([
                            'planning' => 'Planning',
                            'preparation' => 'Preparation',
                            'ongoing' => 'Ongoing',
                            'paused' => 'Paused',
                            'completed' => 'Completed',
                            'on_hold' => 'On Hold',
                            ] as $value => $label)
                            <option value="{{ $value }}" @selected(request('status')==$value)>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="building-label">&nbsp;</label>
                        <button type="submit" class="building-btn building-btn-primary" style="width:100%">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.buildings.index') }}" class="building-btn building-btn-light">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Filters
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- Building List --}}
    <div class="building-card">

        <div class="building-table-header">
            <h5 class="building-table-title">Building List</h5>

            <span class="building-total">
                Total: {{ $buildings->total() }}
            </span>
        </div>

        <div class="building-table-wrap">
            <table class="building-table">

                <thead>
                    <tr>
                        <th width="55">#</th>
                        <th>Building</th>
                        <th>Company / Branch</th>
                        <th>Project</th>
                        <th>Floors / Flats</th>
                        <th>Construction Period</th>
                        <th>Status</th>
                        <th width="130" style="text-align:center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($buildings as $building)

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

                    <tr>
                        <td>
                            {{ $buildings->firstItem() + $loop->index }}
                        </td>

                        <td>
                            <div class="building-name">
                                {{ $building->building_name }}
                            </div>

                            <div class="building-muted">
                                Code: {{ $building->building_code ?: 'N/A' }}
                            </div>
                        </td>

                        <td>
                            <div>{{ $building->company->name ?? 'N/A' }}</div>
                            <div class="building-muted">
                                {{ $building->branch->name ?? 'N/A' }}
                            </div>
                        </td>

                        <td>
                            {{ $building->project->project_name ?? 'N/A' }}
                        </td>

                        <td>
                            <div>
                                Floors:
                                <strong>{{ $building->number_of_floors ?? 0 }}</strong>
                            </div>

                            <div class="building-muted">
                                Flats: {{ $building->total_flats ?? 0 }}
                            </div>
                        </td>

                        <td>
                            <div>
                                Start:
                                {{ $building->construction_start_date?->format('d M Y') ?? 'N/A' }}
                            </div>

                            <div class="building-muted">
                                Expected:
                                {{ $building->expected_completion_date?->format('d M Y') ?? 'N/A' }}
                            </div>
                        </td>

                        <td>
                            <span class="building-status status-{{ $building->status }}">
                                {{ $statusLabels[$building->status] ?? ucfirst($building->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="building-actions">

                                

                                <a href="{{ route('admin.buildings.print', $building->id) }}"   target="_blank"
                                    class="building-action action-view" title="View">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <a href="{{ route('admin.buildings.show', $building->id) }}"
                                    class="building-action action-view" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('admin.buildings.edit', $building->id) }}"
                                    class="building-action action-edit" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this building?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="building-action action-delete" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="8">
                            <div class="building-empty">
                                <i class="bi bi-building"></i>
                                <div>No building records found.</div>
                            </div>
                        </td>
                    </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        @if($buildings->hasPages())
        <div class="building-pagination">
            {{ $buildings->withQueryString()->links() }}
        </div>
        @endif

    </div>

</div>
@endsection