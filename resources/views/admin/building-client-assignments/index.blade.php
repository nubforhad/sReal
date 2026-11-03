@extends('admin.layouts.app')

@section('content')
<div class="bca-page">

    <div class="bca-header">
        <div>
            <h2>Building Client Assignments</h2>
            <p>Manage clients assigned to each building.</p>
        </div>

        <a href="{{ route('admin.building-client-assignments.create') }}"
           class="bca-btn bca-primary">
            + Assign New Client
        </a>
    </div>

    @if(session('success'))
        <div class="bca-alert success">{{ session('success') }}</div>
    @endif

    <div class="bca-card">

        <form method="GET"
              action="{{ route('admin.building-client-assignments.index') }}"
              class="bca-filter">

            <select name="building_id">
                <option value="">All Buildings</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}"
                        {{ request('building_id') == $building->id ? 'selected' : '' }}>
                        {{ $building->building_name }}
                    </option>
                @endforeach
            </select>

            <select name="client_id">
                <option value="">All Clients</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }} ({{ $client->client_code }})
                    </option>
                @endforeach
            </select>

            <select name="status">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                    Active
                </option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            <button type="submit" class="bca-btn bca-primary">Filter</button>

            <a href="{{ route('admin.building-client-assignments.index') }}"
               class="bca-btn bca-light">Reset</a>
        </form>

        <div class="bca-table-wrap">
            <table class="bca-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Building</th>
                        <th>Project</th>
                        <th>Client</th>
                        <th>Client Code</th>
                        <th>Phone</th>
                        <th>Assigned Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($assignments as $key => $assignment)
                        <tr>
                            <td>{{ $assignments->firstItem() + $key }}</td>

                            <td>
                                <strong>
                                    {{ $assignment->building->building_name ?? 'N/A' }}
                                </strong>
                            </td>

                            <td>
                                {{ $assignment->project->project_name ?? 'N/A' }}
                            </td>

                            <td>{{ $assignment->client->name ?? 'N/A' }}</td>

                            <td>
                                {{ $assignment->client->client_code ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $assignment->client->phone ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $assignment->assigned_at?->format('d M Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="bca-badge {{ $assignment->status }}">
                                    {{ ucfirst($assignment->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="bca-actions">

                                    <a href="{{ route('admin.building-client-assignments.edit', $assignment->id) }}"
                                       class="bca-btn bca-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.building-client-assignments.destroy', $assignment->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this assignment?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="bca-btn bca-delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="bca-empty">
                                No building client assignments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bca-pagination">
            {{ $assignments->links() }}
        </div>

    </div>
</div>

<style>
.bca-page { padding:20px; color:#334155; }
.bca-header { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:20px; }
.bca-header h2 { font-size:23px; font-weight:700; color:#0f172a; margin:0; }
.bca-header p { color:#64748b; margin:5px 0 0; font-size:13px; }
.bca-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:18px; }
.bca-filter { display:flex; flex-wrap:wrap; gap:10px; margin-bottom:18px; }
.bca-filter select { min-width:170px; flex:1; border:1px solid #cbd5e1; border-radius:8px; padding:9px 12px; background:#fff; }
.bca-btn { display:inline-flex; align-items:center; justify-content:center; padding:9px 13px; border:0; border-radius:7px; font-size:13px; font-weight:600; text-decoration:none; cursor:pointer; white-space:nowrap; }
.bca-primary { background:#2563eb; color:#fff; }
.bca-light { background:#f1f5f9; color:#475569; }
.bca-edit { background:#eff6ff; color:#1d4ed8; }
.bca-delete { background:#fef2f2; color:#dc2626; }
.bca-table-wrap { width:100%; overflow-x:auto; }
.bca-table { width:100%; border-collapse:collapse; min-width:950px; }
.bca-table th { background:#f8fafc; color:#475569; font-size:12px; text-align:left; padding:12px; white-space:nowrap; }
.bca-table td { border-top:1px solid #e2e8f0; padding:12px; font-size:13px; }
.bca-badge { display:inline-block; padding:4px 9px; border-radius:20px; font-size:11px; font-weight:600; }
.bca-badge.active { background:#dcfce7; color:#15803d; }
.bca-badge.inactive { background:#f1f5f9; color:#64748b; }
.bca-actions { display:flex; gap:6px; }
.bca-alert { padding:12px 15px; border-radius:8px; margin-bottom:15px; font-size:13px; }
.bca-alert.success { background:#dcfce7; color:#166534; }
.bca-empty { text-align:center; padding:30px !important; color:#94a3b8; }
.bca-pagination { margin-top:18px; }
@media(max-width:640px) {
    .bca-page { padding:10px; }
    .bca-header { align-items:flex-start; flex-direction:column; }
    .bca-filter { flex-direction:column; }
    .bca-filter select, .bca-filter button, .bca-filter a { width:100%; }
}
</style>
@endsection