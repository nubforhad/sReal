@extends('admin.layouts.app')

@section('content')
<div class="bca-form-page">

    <div class="bca-form-header">
        <div>
            <h2>Edit Building Client Assignment</h2>
            <p>Update assigned building, client and assignment information.</p>
        </div>

        <a href="{{ route('admin.building-client-assignments.index') }}"
           class="bca-back">← Back to List</a>
    </div>

    <div class="bca-form-card">

        @if($errors->any())
            <div class="bca-error">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.building-client-assignments.update', $assignment->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="bca-form-grid">

                <div class="bca-field full">
                    <label>Building <span>*</span></label>

                    <select name="building_id" id="building_id" required>
                        <option value="">Select Building</option>

                        @foreach($buildings as $building)
                            <option value="{{ $building->id }}"
                                    data-project="{{ $building->project_id }}"
                                {{ old('building_id', $assignment->building_id) == $building->id ? 'selected' : '' }}>

                                {{ $building->building_name }}
                                @if($building->building_code)
                                    ({{ $building->building_code }})
                                @endif
                            </option>
                        @endforeach
                    </select>

                    @error('building_id')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="bca-field full">
                    <label>Client <span>*</span></label>

                    <select name="client_id" id="client_id" required>
                        <option value="">Select Client</option>

                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                    data-project="{{ $client->project_id }}"
                                {{ old('client_id', $assignment->client_id) == $client->id ? 'selected' : '' }}>

                                {{ $client->name }}
                                ({{ $client->client_code }})
                            </option>
                        @endforeach
                    </select>

                    @error('client_id')
                        <small>{{ $message }}</small>
                    @enderror
                </div>

                <div class="bca-field">
                    <label>Assigned Date</label>

                    <input type="date"
                           name="assigned_at"
                           value="{{ old('assigned_at', $assignment->assigned_at?->format('Y-m-d')) }}">
                </div>

                <div class="bca-field">
                    <label>Status <span>*</span></label>

                    <select name="status" required>
                        <option value="active"
                            {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ old('status', $assignment->status) == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                <div class="bca-field full">
                    <label>Remarks</label>

                    <textarea name="remarks"
                              rows="4"
                              placeholder="Write assignment remarks...">{{ old('remarks', $assignment->remarks) }}</textarea>
                </div>

            </div>

            <div class="bca-form-footer">
                <a href="{{ route('admin.building-client-assignments.index') }}"
                   class="bca-cancel">Cancel</a>

                <button type="submit" class="bca-submit">
                    Update Assignment
                </button>
            </div>

        </form>
    </div>
</div>

<style>
.bca-form-page { padding:20px; color:#334155; }
.bca-form-header { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:20px; }
.bca-form-header h2 { margin:0; font-size:23px; font-weight:700; color:#0f172a; }
.bca-form-header p { margin:5px 0 0; font-size:13px; color:#64748b; }
.bca-back { color:#2563eb; text-decoration:none; font-size:13px; font-weight:600; }
.bca-form-card { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; }
.bca-form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:20px; }
.bca-field { display:flex; flex-direction:column; gap:7px; }
.bca-field.full { grid-column:1/-1; }
.bca-field label { font-size:13px; font-weight:600; color:#334155; }
.bca-field label span { color:#dc2626; }
.bca-field input,.bca-field select,.bca-field textarea { width:100%; border:1px solid #cbd5e1; border-radius:8px; padding:10px 12px; font-size:13px; outline:none; background:#fff; color:#334155; }
.bca-field input:focus,.bca-field select:focus,.bca-field textarea:focus { border-color:#3b82f6; box-shadow:0 0 0 3px #dbeafe; }
.bca-field small { color:#dc2626; font-size:12px; }
.bca-form-footer { display:flex; justify-content:flex-end; gap:10px; border-top:1px solid #e2e8f0; margin-top:24px; padding-top:18px; }
.bca-submit,.bca-cancel { border:0; border-radius:7px; padding:10px 17px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; }
.bca-submit { background:#2563eb; color:#fff; }
.bca-cancel { background:#f1f5f9; color:#475569; }
.bca-error { padding:12px 15px; margin-bottom:20px; background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; border-radius:8px; font-size:13px; }
.bca-error ul { margin:7px 0 0 18px; }
@media(max-width:640px) {
    .bca-form-page { padding:10px; }
    .bca-form-header { align-items:flex-start; flex-direction:column; }
    .bca-form-card { padding:15px; }
    .bca-form-grid { grid-template-columns:1fr; }
    .bca-field.full { grid-column:auto; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const buildingSelect = document.getElementById('building_id');
    const clientSelect = document.getElementById('client_id');

    const allClients = Array.from(clientSelect.options).slice(1);

    function filterClients() {

        const buildingOption =
            buildingSelect.options[buildingSelect.selectedIndex];

        const projectId = buildingOption
            ? buildingOption.dataset.project
            : '';

        const previousClient = clientSelect.value;

        clientSelect.innerHTML = '<option value="">Select Client</option>';

        allClients.forEach(function (option) {

            if (projectId && option.dataset.project === projectId) {
                clientSelect.appendChild(option.cloneNode(true));
            }

        });

        if (Array.from(clientSelect.options).some(option => option.value === previousClient)) {
            clientSelect.value = previousClient;
        }
    }

    buildingSelect.addEventListener('change', filterClients);

    filterClients();

});
</script>
@endsection