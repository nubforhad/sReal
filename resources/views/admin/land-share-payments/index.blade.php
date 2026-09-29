@extends('admin.layouts.app')

@section('title', 'Land Share Payments')
@section('page-title', 'Land Share Payments')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Land Share Payments
            </h1>
            <p class="text-sm text-slate-500">
                Manage land share payment receipts and payment history.
            </p>
        </div>

        <a href="{{ route('admin.land-share-payments.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
            <i class="bi bi-plus-lg"></i>
            Add Payment
        </a>
    </div>

    {{-- Filters --}}
    <div class="erp-card p-4">
        <form method="GET"
              action="{{ route('admin.land-share-payments.index') }}">

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">

                {{-- Search --}}
                <div class="xl:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Search
                    </label>

                    <div class="relative">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Receipt, transaction, client, sale code..."
                            class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-3 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </div>
                </div>

                {{-- Company --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Company
                    </label>

                    <select name="company_id"
                            id="company_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">
                        <option value="">All Companies</option>

                        @foreach($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Branch --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Branch
                    </label>

                    <select name="branch_id"
                            id="branch_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">
                        <option value="">All Branches</option>

                        @foreach($branches as $branch)
                            <option
                                value="{{ $branch->id }}"
                                data-company="{{ $branch->company_id }}"
                                {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Project --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Project
                    </label>

                    <select name="project_id"
                            id="project_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">
                        <option value="">All Projects</option>

                        @foreach($projects as $project)
                            <option
                                value="{{ $project->id }}"
                                data-company="{{ $project->company_id }}"
                                data-branch="{{ $project->branch_id }}"
                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                {{ $project->project_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-4 flex flex-wrap gap-2">

                <select name="payment_method"
                        class="rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm">
                    <option value="">All Payment Methods</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>
                        Cash
                    </option>
                    <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>
                        Bank
                    </option>
                    <option value="cheque" {{ request('payment_method') == 'cheque' ? 'selected' : '' }}>
                        Cheque
                    </option>
                    <option value="mobile_banking" {{ request('payment_method') == 'mobile_banking' ? 'selected' : '' }}>
                        Mobile Banking
                    </option>
                    <option value="online" {{ request('payment_method') == 'online' ? 'selected' : '' }}>
                        Online
                    </option>
                    <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>
                        Other
                    </option>
                </select>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-900">
                    <i class="bi bi-funnel"></i>
                    Filter
                </button>

                <a href="{{ route('admin.land-share-payments.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </a>

            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="erp-card overflow-hidden">

        <div class="border-b border-slate-200 px-4 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-semibold text-slate-800">
                        Payment Records
                    </h2>
                    <p class="text-xs text-slate-500">
                        {{ $payments->total() }} total payment(s)
                    </p>
                </div>

                <div class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    Total Records: {{ $payments->total() }}
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">Receipt</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Sale</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Method</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($payments as $payment)

                        <tr class="hover:bg-slate-50">

                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">
                                    {{ $payment->receipt_no }}
                                </div>

                                @if($payment->transaction_no)
                                    <div class="text-xs text-slate-500">
                                        {{ $payment->transaction_no }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap text-slate-600">
                                {{ $payment->payment_date?->format('d M Y') }}
                            </td>

                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">
                                    {{ $payment->client?->name ?? 'N/A' }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $payment->client?->phone ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="font-medium text-blue-700">
                                    {{ $payment->landShareSale?->sale_code ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="text-slate-700">
                                    {{ $payment->project?->project_name ?? 'N/A' }}
                                </div>

                                <div class="text-xs text-slate-500">
                                    {{ $payment->branch?->name ?? '' }}
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="font-bold text-emerald-700">
                                    ৳ {{ number_format((float) $payment->amount, 2) }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $methodLabels = [
                                        'cash' => 'Cash',
                                        'bank' => 'Bank',
                                        'cheque' => 'Cheque',
                                        'mobile_banking' => 'Mobile Banking',
                                        'online' => 'Online',
                                        'other' => 'Other',
                                    ];
                                @endphp

                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-700">
                                    {{ $methodLabels[$payment->payment_method] ?? ucfirst($payment->payment_method) }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-1">

                                    <a href="{{ route('admin.land-share-payments.show', $payment) }}"
                                       title="View"
                                       class="rounded-lg p-2 text-blue-600 hover:bg-blue-50">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.land-share-payments.edit', $payment) }}"
                                       title="Edit"
                                       class="rounded-lg p-2 text-amber-600 hover:bg-amber-50">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('admin.land-share-payments.destroy', $payment) }}"
                                          class="delete-payment-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete"
                                                class="rounded-lg p-2 text-red-600 hover:bg-red-50">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-4 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                                        <i class="bi bi-cash-stack text-xl text-slate-400"></i>
                                    </div>

                                    <h3 class="font-semibold text-slate-700">
                                        No payment records found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add a land share payment to get started.
                                    </p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="border-t border-slate-200 px-4 py-4">
                {{ $payments->links() }}
            </div>
        @endif

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');
    const projectSelect = document.getElementById('project_id');

    function filterBranchAndProject() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = companyId &&
                option.dataset.company !== companyId;
        });

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = companyId &&
                option.dataset.company !== companyId;
        });
    }

    companySelect.addEventListener('change', function () {
        branchSelect.value = '';
        projectSelect.value = '';
        filterBranchAndProject();
    });

    branchSelect.addEventListener('change', function () {

        const branchId = branchSelect.value;
        const companyId = companySelect.value;

        Array.from(projectSelect.options).forEach(option => {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                (companyId && option.dataset.company !== companyId) ||
                (branchId && option.dataset.branch !== branchId);
        });

        projectSelect.value = '';
    });

    filterBranchAndProject();

    document.querySelectorAll('.delete-payment-form').forEach(form => {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            if (typeof Swal !== 'undefined') {

                Swal.fire({
                    title: 'Delete Payment?',
                    text: 'This payment record will be permanently deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, Delete'
                }).then((result) => {

                    if (result.isConfirmed) {
                        form.submit();
                    }

                });

            } else {

                if (confirm('Are you sure you want to delete this payment?')) {
                    form.submit();
                }

            }

        });

    });

});
</script>
@endpush