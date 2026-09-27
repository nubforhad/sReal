@extends('admin.layouts.app')

@section('title', 'Projects')

@section('content')

<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Projects
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Manage all company and branch-wise projects.
            </p>
        </div>
        <a href="{{ route('admin.projects.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5
                  bg-blue-600 hover:bg-blue-700 text-white rounded-lg
                  text-sm font-medium transition">
            <i class="bi bi-plus-lg"></i>
            Add Project
        </a>
    </div>
    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700
                    px-4 py-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    {{-- Error Message --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Table --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left text-slate-600">
                        <th class="px-4 py-3 font-semibold">#</th>
                        <th class="px-4 py-3 font-semibold">  Project </th>
                        <th class="px-4 py-3 font-semibold"> Company </th>
                        <th class="px-4 py-3 font-semibold"> Branch </th>
                        <th class="px-4 py-3 font-semibold"> Type </th>
                        <th class="px-4 py-3 font-semibold">  Size </th>
                        <th class="px-4 py-3 font-semibold"> Share  </th>
                        <th class="px-4 py-3 font-semibold">  Working </th>
                        <th class="px-4 py-3 font-semibold"> Status </th>
                        <th class="px-4 py-3 font-semibold text-right"> Action </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($projects as $project)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3 text-slate-500">
                                {{ $projects->firstItem() + $loop->index }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    @if($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}"
                                             alt="{{ $project->project_name }}"
                                             class="w-12 h-12 rounded-lg object-cover
                                                    border border-slate-200">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-slate-100  border border-slate-200 flex items-center justify-center">
                                            <i class="bi bi-building text-slate-400 text-lg"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.projects.show', $project) }}"  class="font-semibold text-slate-800 hover:text-blue-600">
                                            {{ $project->project_name }}
                                        </a>
                                        <div class="text-xs text-slate-500 mt-1">
                                            {{ $project->project_code }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $project->company->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $project->branch->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $project->project_type ?: '—' }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $project->size ?: '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $shareClasses = [
                                        'available' => 'bg-green-50 text-green-700',
                                        'limited' => 'bg-yellow-50 text-yellow-700',
                                        'sold_out' => 'bg-red-50 text-red-700',
                                        'closed' => 'bg-slate-100 text-slate-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $shareClasses[$project->share_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $project->share_status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $workingClasses = [
                                        'not_started' => 'bg-slate-100 text-slate-700',
                                        'ongoing' => 'bg-blue-50 text-blue-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                        'on_hold' => 'bg-yellow-50 text-yellow-700',
                                    ];
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             text-xs font-medium
                                             {{ $workingClasses[$project->working_status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $project->working_status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusClasses = [
                                        'planning' => 'bg-purple-50 text-purple-700',
                                        'ongoing' => 'bg-blue-50 text-blue-700',
                                        'completed' => 'bg-green-50 text-green-700',
                                        'on_hold' => 'bg-yellow-50 text-yellow-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                    ];
                                @endphp

                                <span class="inline-flex px-2.5 py-1 rounded-full
                                             text-xs font-medium
                                             {{ $statusClasses[$project->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucwords(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </td>
                            {{-- Actions --}}
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.projects.show', $project) }}"
                                       title="View"
                                       class="w-9 h-9 inline-flex items-center justify-center
                                              rounded-lg text-slate-600 hover:bg-slate-100">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.projects.edit', $project) }}"
                                       title="Edit"
                                       class="w-9 h-9 inline-flex items-center justify-center
                                              rounded-lg text-blue-600 hover:bg-blue-50">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}"  method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                title="Delete"
                                                class="w-9 h-9 inline-flex items-center justify-center
                                                       rounded-lg text-red-600 hover:bg-red-50">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10"  class="px-4 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="bi bi-building text-4xl text-slate-300"></i>
                                    <p class="mt-3 font-medium">
                                        No projects found.
                                    </p>
                                    <a href="{{ route('admin.projects.create') }} class="mt-3 text-blue-600 hover:underline text-sm">
                                        Add your first project
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="px-4 py-4 border-t border-slate-200">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</div>
{{-- Delete Confirmation --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'This project will be deleted permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });
</script>

@endsection