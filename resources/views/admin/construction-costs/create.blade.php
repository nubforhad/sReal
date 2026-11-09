@extends('admin.layouts.app')

@section('content')

<div class="mx-auto max-w-5xl p-4">

    <div class="mb-5">
        <h2 class="text-xl font-bold text-slate-800">Add Construction Cost</h2>
        <p class="text-sm text-slate-500">
            Record a construction payment against an assigned client.
        </p>
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

    <form action="{{ route('admin.construction-costs.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-slate-200 bg-white p-5">

        @csrf

        {{-- PROJECT & CLIENT INFORMATION --}}
        <div>
            <h3 class="mb-4 border-b border-slate-100 pb-2 text-base font-semibold text-slate-800">
                Project & Client Information
            </h3>

            <div class="grid gap-4 sm:grid-cols-2">

                {{-- Project --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Project *
                    </label>

                    <select name="project_id" id="project_id" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">
                        <option value="">Select Project</option>

                        @foreach($projects as $project)
                        <option value="{{ $project->id }}" @selected(old('project_id')==$project->id)>
                            {{ $project->project_name }}
                        </option>
                        @endforeach
                    </select>

                    @error('project_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Building --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Building *
                    </label>

                    <select name="building_id" id="building_id" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">
                        <option value="">Select Building</option>

                        @foreach($assignments->unique('building_id') as $assignment)
                        <option value="{{ $assignment->building_id }}" data-project="{{ $assignment->project_id }}"
                            @selected(old('building_id')==$assignment->building_id)>
                            {{ $assignment->building->building_name ?? 'Building' }}
                        </option>
                        @endforeach
                    </select>

                    @error('building_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Receipt No
                    </label>

                    <input
                        type="text"
                        value="Auto Generated"
                        readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-slate-500"
                    >
                </div>

                {{-- Assigned Client --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Assigned Client *
                    </label>

                    <select name="building_client_assignment_id" id="assignment_id" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">

                        <option value="">Select Client</option>

                        @foreach($assignments as $assignment)
                        <option value="{{ $assignment->id }}" data-building="{{ $assignment->building_id }}"
                            data-project="{{ $assignment->project_id }}"
                            data-client-code="{{ $assignment->client->client_code ?? '' }}"
                            data-client-address="{{ $assignment->client->address ?? '' }}"
                            @selected(old('building_client_assignment_id')==$assignment->id)>

                            {{ $assignment->client->name ?? 'Client' }}

                        </option>
                        @endforeach

                    </select>

                    @error('building_client_assignment_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Client Code --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Customer ID / Client Code
                    </label>

                    <input type="text" id="client_code" readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2"
                        placeholder="Automatic Client Code">
                </div>

                {{-- Client Address --}}
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Address
                    </label>

                    <textarea id="client_address" rows="2" readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2"
                        placeholder="Automatic Client Address"></textarea>
                </div>

            </div>
        </div>


        {{-- RECEIPT INFORMATION --}}
        <div>
            <h3 class="mb-4 border-b border-slate-100 pb-2 text-base font-semibold text-slate-800">
                Money Receipt Information
            </h3>

            <div class="grid gap-4 sm:grid-cols-2">

                {{-- Purpose --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Purpose *
                    </label>

                    <select name="purpose" required class="w-full rounded-lg border border-slate-200 px-3 py-2">

                        <option value="">Select Purpose</option>

                        @foreach(['Booking', 'Down Payment', 'Installment', 'Others'] as $purpose)
                        <option value="{{ $purpose }}" @selected(old('purpose')==$purpose)>
                            {{ $purpose }}
                        </option>
                        @endforeach

                    </select>

                    @error('purpose')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Payment Method --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Through *
                    </label>

                    <select name="payment_method" required class="w-full rounded-lg border border-slate-200 px-3 py-2">

                        <option value="">Select Payment Method</option>

                        @foreach(['Cash', 'RTGS', 'NPSB', 'EFTN', 'PO', 'Online', 'Cheque'] as $method)
                        <option value="{{ $method }}" @selected(old('payment_method')==$method)>
                            {{ $method }}
                        </option>
                        @endforeach

                    </select>

                    @error('payment_method')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Cheque / Transaction --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Cheque / Transaction No.
                    </label>

                    <input type="text" name="cheque_no" value="{{ old('cheque_no') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2"
                        placeholder="Enter Cheque / Transaction No.">

                    @error('cheque_no')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Bank Name --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Bank Name
                    </label>

                    <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="Enter Bank Name">

                    @error('bank_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Bank Branch --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Bank Branch
                    </label>

                    <input type="text" name="bank_branch" value="{{ old('bank_branch') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="Enter Bank Branch">

                    @error('bank_branch')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>


        {{-- COST INFORMATION --}}
        <div>
            <h3 class="mb-4 border-b border-slate-100 pb-2 text-base font-semibold text-slate-800">
                Cost Information
            </h3>

            <div class="grid gap-4 sm:grid-cols-2">

                {{-- Category --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Cost Category *
                    </label>

                    <select name="construction_cost_category_id" id="category_id" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">

                        <option value="">Select Category</option>

                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" data-project="{{ $category->project_id }}"
                            @selected(old('construction_cost_category_id')==$category->id)>
                            {{ $category->category_name }}
                        </option>
                        @endforeach

                    </select>

                    @error('construction_cost_category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Cost Date --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                         Date *
                    </label>

                    <input type="date" name="cost_date" value="{{ old('cost_date', date('Y-m-d')) }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">

                    @error('cost_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Payment Date --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Payment Date
                    </label>

                    <input type="date" name="payment_date" value="{{ old('payment_date') }}"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2">

                    @error('payment_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Amount --}}
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Amount (৳) *
                    </label>

                    <input type="number" name="amount" id="amount" step="0.01" min="0.01" value="{{ old('amount') }}"
                        required class="w-full rounded-lg border border-slate-200 px-3 py-2" placeholder="Enter amount">

                    @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Amount in Words --}}
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Amount in Words
                    </label>

                    <input type="text" name="amount_words" id="amount_words" value="{{ old('amount_words') }}" readonly
                        class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2"
                        placeholder="Automatic amount in words">

                    @error('amount_words')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Document --}}
                <div class="sm:col-span-2">
                    <label class="mb-1 block text-sm font-medium text-slate-700">
                        Document
                    </label>

                    <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">

                    <p class="mt-1 text-xs text-slate-500">
                        PDF, JPG, PNG, DOC, DOCX. Maximum 5 MB.
                    </p>

                    @error('document')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>


        {{-- DESCRIPTION --}}
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">
                Description
            </label>

            <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-200 px-3 py-2"
                placeholder="Enter details...">{{ old('description') }}</textarea>

            @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        {{-- BUTTONS --}}
        <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">

            <a href="{{ route('admin.construction-costs.index') }}"
                class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
                Cancel
            </a>

            <button type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                Save Cost & Receipt
            </button>

        </div>

    </form>
</div>


{{-- JAVASCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

    const project = document.getElementById('project_id');
    const building = document.getElementById('building_id');
    const assignment = document.getElementById('assignment_id');
    const category = document.getElementById('category_id');

    const clientCode = document.getElementById('client_code');
    const clientAddress = document.getElementById('client_address');

    const amountInput = document.getElementById('amount');
    const amountWords = document.getElementById('amount_words');


    // CLIENT INFORMATION
    function updateClientDetails() {

        const selected = assignment.options[assignment.selectedIndex];

        if (!selected || !selected.value) {
            clientCode.value = '';
            clientAddress.value = '';
            return;
        }

        clientCode.value = selected.dataset.clientCode || '';
        clientAddress.value = selected.dataset.clientAddress || '';
    }


    // BUILDING FILTER
    function filterBuildings() {

        const projectId = project.value;

        Array.from(building.options).forEach(option => {

            if (!option.value) return;

            option.hidden = option.dataset.project !== projectId;

        });

        if (building.selectedOptions[0]?.hidden) {
            building.value = '';
        }
    }


    // CLIENT FILTER
    function filterAssignments() {

        const buildingId = building.value;

        Array.from(assignment.options).forEach(option => {

            if (!option.value) return;

            option.hidden = option.dataset.building !== buildingId;

        });

        if (assignment.selectedOptions[0]?.hidden) {
            assignment.value = '';
        }

        updateClientDetails();
    }


    // CATEGORY FILTER
    function filterCategories() {

        const projectId = project.value;

        Array.from(category.options).forEach(option => {

            if (!option.value) return;

            option.hidden = option.dataset.project !== projectId;

        });

        if (category.selectedOptions[0]?.hidden) {
            category.value = '';
        }
    }


    // NUMBER TO WORDS
    function numberToWords(number) {

        const ones = [
            '', 'One', 'Two', 'Three', 'Four', 'Five',
            'Six', 'Seven', 'Eight', 'Nine', 'Ten',
            'Eleven', 'Twelve', 'Thirteen', 'Fourteen',
            'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen',
            'Nineteen'
        ];

        const tens = [
            '', '', 'Twenty', 'Thirty', 'Forty',
            'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
        ];

        function convert(n) {

            if (n === 0) return '';

            if (n < 20) return ones[n];

            if (n < 100) {
                return tens[Math.floor(n / 10)] +
                    (n % 10 ? ' ' + ones[n % 10] : '');
            }

            if (n < 1000) {
                return ones[Math.floor(n / 100)] + ' Hundred' +
                    (n % 100 ? ' ' + convert(n % 100) : '');
            }

            if (n < 100000) {
                return convert(Math.floor(n / 1000)) + ' Thousand' +
                    (n % 1000 ? ' ' + convert(n % 1000) : '');
            }

            if (n < 10000000) {
                return convert(Math.floor(n / 100000)) + ' Lakh' +
                    (n % 100000 ? ' ' + convert(n % 100000) : '');
            }

            return convert(Math.floor(n / 10000000)) + ' Crore' +
                (n % 10000000 ? ' ' + convert(n % 10000000) : '');
        }

        if (!Number.isFinite(number) || number < 0) return '';

        const taka = Math.floor(number);
        const paisa = Math.round((number - taka) * 100);

        let result = taka === 0 ? 'Zero' : convert(taka);

        result += ' Taka';

        if (paisa > 0) {
            result += ' and ' + convert(paisa) + ' Paisa';
        }

        return result + ' Only';
    }


    function updateAmountWords() {

        const value = amountInput.value;

        if (value === '' || !Number.isFinite(Number(value)) || Number(value) < 0) {
            amountWords.value = '';
            return;
        }

        amountWords.value = numberToWords(Number(value));
    }


    // EVENTS
    project.addEventListener('change', function () {

        filterBuildings();
        filterAssignments();
        filterCategories();

    });

    building.addEventListener('change', filterAssignments);

    assignment.addEventListener('change', updateClientDetails);

    amountInput.addEventListener('input', updateAmountWords);


    // RESTORE OLD VALUES AFTER VALIDATION ERROR
    filterBuildings();
    filterCategories();

    filterAssignments();

    updateClientDetails();
    updateAmountWords();

});
</script>

@endsection