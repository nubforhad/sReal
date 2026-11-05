
@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-4xl p-4">

    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Edit Construction Cost</h2>
        <p class="text-sm text-slate-500">Update building and client construction cost.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.construction-costs.update', $cost->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-xl border border-slate-200 bg-white p-5">
        @csrf
        @method('PUT')
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Project *</label>
                <select name="project_id" id="project_id" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">
                    <option value="">Select Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}"
                            @selected(old('project_id', $cost->project_id) == $project->id)>
                            {{ $project->project_name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Building *</label>
                <select name="building_id" id="building_id" required class="w-full rounded-lg border border-slate-200 px-3 py-2">
                    <option value="">Select Building</option>
                    @foreach($assignments->unique('building_id') as $assignment)
                        <option value="{{ $assignment->building_id }}" data-project="{{ $assignment->project_id }}"
                                @selected(old('building_id', $cost->building_id) == $assignment->building_id)>
                            {{ $assignment->building->building_name ?? 'Building' }}
                        </option>
                    @endforeach
                </select>
                @error('building_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Assigned Client *</label>
                <select name="building_client_assignment_id" id="assignment_id" required class="w-full rounded-lg border border-slate-200 px-3 py-2">
                    <option value="">Select Client</option>
                    @foreach($assignments as $assignment)
                        <option value="{{ $assignment->id }}" data-building="{{ $assignment->building_id }}" data-project="{{ $assignment->project_id }}"
                                @selected(old('building_client_assignment_id', $cost->building_client_assignment_id) == $assignment->id)>
                            {{ $assignment->client->name ?? 'Client' }}
                        </option>
                    @endforeach
                </select>
                @error('building_client_assignment_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Cost Category *</label>
                <select name="construction_cost_category_id" id="category_id" required class="w-full rounded-lg border border-slate-200 px-3 py-2">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                data-project="{{ $category->project_id }}"
                                @selected(old('construction_cost_category_id', $cost->construction_cost_category_id) == $category->id)>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('construction_cost_category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Cost Date *</label>
                <input type="date" name="cost_date"
                       value="{{ old('cost_date', $cost->cost_date?->format('Y-m-d')) }}"
                       required class="w-full rounded-lg border border-slate-200 px-3 py-2">
                @error('cost_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Payment Date</label>
                <input type="date" name="payment_date"  value="{{ old('payment_date', $cost->payment_date?->format('Y-m-d')) }}"  class="w-full rounded-lg border border-slate-200 px-3 py-2">
                @error('payment_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Amount (৳) *</label>
                <input type="number" name="amount" step="0.01" min="0.01"
                       value="{{ old('amount', $cost->amount) }}" required
                       class="w-full rounded-lg border border-slate-200 px-3 py-2">
                @error('amount') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Replace Document</label>
                <input type="file" name="document"  accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                @if($cost->document)
                    <a href="{{ asset('storage/'.$cost->document) }}" target="_blank"
                       class="mt-2 inline-block text-sm text-blue-600 underline">
                        View Current Document
                    </a>
                @endif

                @error('document') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-lg border border-slate-200 px-3 py-2">{{ old('description', $cost->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
            <a href="{{ route('admin.construction-costs.index') }}"
               class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
                Cancel
            </a>
            <button type="submit"
                    class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white">
                Update Cost
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const project = document.getElementById('project_id');
    const building = document.getElementById('building_id');
    const assignment = document.getElementById('assignment_id');
    const category = document.getElementById('category_id');

    function filterBuildings() {
        Array.from(building.options).forEach(option => {
            if (!option.value) return;
            option.hidden = option.dataset.project !== project.value;
        });

        if (building.selectedOptions[0]?.hidden) building.value = '';
    }
    function filterAssignments() {
        Array.from(assignment.options).forEach(option => {
            if (!option.value) return;
            option.hidden = option.dataset.building !== building.value;
        });

        if (assignment.selectedOptions[0]?.hidden) assignment.value = '';
    }

    function filterCategories() {
        Array.from(category.options).forEach(option => {
            if (!option.value) return;
            option.hidden = option.dataset.project !== project.value;
        });
        if (category.selectedOptions[0]?.hidden) category.value = '';
    }
    project.addEventListener('change', function () {
        filterBuildings();
        filterAssignments();
        filterCategories();
    });

    building.addEventListener('change', filterAssignments);

    filterBuildings();
    filterCategories();
    filterAssignments();
});
</script>
@endsection
