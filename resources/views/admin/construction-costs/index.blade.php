
@extends('admin.layouts.app')

@section('content')
<div class="p-4 space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Construction Cost Entry</h2>
            <p class="text-sm text-slate-500">Building and client-wise construction expenses.</p>
        </div>
        <a href="{{ route('admin.construction-costs.create') }}"
           class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
            + Add Construction Cost
        </a>
    </div>
    @if(session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="GET" class="flex flex-wrap gap-3 rounded-xl border border-slate-200 bg-white p-4">
        <select name="project_id" class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
            <option value="">All Projects</option>
            @foreach($projects as $project)
                <option value="{{ $project->id }}" @selected(request('project_id') == $project->id)>
                    {{ $project->project_name }}
                </option>
            @endforeach
        </select>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
        <input type="date" name="to_date" value="{{ request('to_date') }}"  class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm text-white">
            Filter
        </button>
        <a href="{{ route('admin.construction-costs.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm">
            Reset
        </a>
    </form>
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Building</th>
                        <th class="px-4 py-3">Client</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($costs as $cost)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3">
                                {{ $costs->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $cost->cost_date?->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $cost->building->building_name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $cost->client->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $cost->category->category_name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-right font-semibold">
                                ৳{{ number_format((float)$cost->amount, 2) }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.construction-costs.show', $cost->id) }}" class="rounded-md border border-slate-200 px-3 py-1.5 text-blue-600">
                                        View
                                    </a>
                                    <a href="{{ route('admin.construction-costs.edit', $cost->id) }}" class="rounded-md border border-slate-200 px-3 py-1.5 text-green-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.construction-costs.destroy', $cost->id) }}" method="POST"  onsubmit="return confirm('Are you sure you want to delete this cost entry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-10 text-center text-slate-500">
                                No construction cost entries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-200 p-4">
            {{ $costs->links() }}
        </div>
    </div>
</div>
@endsection
