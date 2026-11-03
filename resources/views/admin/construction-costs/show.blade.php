
@extends('admin.layouts.app')

@section('content')
<div class="mx-auto max-w-4xl p-4">

    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Construction Cost Details</h2>
            <p class="text-sm text-slate-500">Complete expense information.</p>
        </div>

        <a href="{{ route('admin.construction-costs.index') }}"
           class="rounded-lg border border-slate-200 px-4 py-2 text-sm text-slate-600">
            Back
        </a>
    </div>

    <div class="space-y-5 rounded-xl border border-slate-200 bg-white p-5">
        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <p class="text-xs text-slate-500">Project</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->project->project_name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Building</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->building->building_name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Client</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->client->name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Category</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->category->category_name ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Cost Date</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->cost_date?->format('d M Y') ?? '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Payment Date</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->payment_date?->format('d M Y') ?? 'Not Paid / Not Entered' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Amount</p>
                <p class="mt-1 text-xl font-bold text-blue-700">
                    ৳{{ number_format((float)$cost->amount, 2) }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-500">Created By</p>
                <p class="mt-1 font-semibold text-slate-800">
                    {{ $cost->creator->name ?? '-' }}
                </p>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4">
            <p class="text-xs text-slate-500">Description</p>
            <p class="mt-1 whitespace-pre-line text-sm text-slate-700">
                {{ $cost->description ?? '-' }}
            </p>
        </div>
        @if($cost->document)
            <div class="border-t border-slate-100 pt-4">
                <p class="mb-2 text-xs text-slate-500">Attached Document</p>
                <a href="{{ asset('storage/'.$cost->document) }}"
                   target="_blank"
                   class="text-sm font-medium text-blue-600 underline">
                    View / Download Document
                </a>
            </div>
        @endif
        <div class="flex justify-end border-t border-slate-100 pt-4">
            <a href="{{ route('admin.construction-costs.edit', $cost->id) }}"
               class="rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white">
                Edit Cost
            </a>
        </div>
    </div>
</div>
@endsection
