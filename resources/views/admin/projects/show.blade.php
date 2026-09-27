@extends('admin.layouts.app')

@section('title', 'Project Details')

@section('content')

<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center
                sm:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                {{ $project->project_name }}
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                {{ $project->project_code }}
            </p>

        </div>


        <div class="flex items-center gap-2">

            <a href="{{ route('admin.projects.edit', $project) }}"
               class="inline-flex items-center gap-2
                      px-4 py-2.5 bg-blue-600 hover:bg-blue-700
                      text-white rounded-lg text-sm font-medium">

                <i class="bi bi-pencil-square"></i>

                Edit

            </a>


            <a href="{{ route('admin.projects.index') }}"
               class="inline-flex items-center gap-2
                      px-4 py-2.5 border border-slate-200
                      bg-white hover:bg-slate-50
                      text-slate-700 rounded-lg text-sm font-medium">

                <i class="bi bi-arrow-left"></i>

                Back

            </a>

        </div>

    </div>


    {{-- Project Header Card --}}
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">

        <div class="grid grid-cols-1 lg:grid-cols-3">


            {{-- Image --}}
            <div class="lg:col-span-1">

                @if($project->image)

                    <img src="{{ asset('storage/' . $project->image) }}"
                         alt="{{ $project->project_name }}"
                         class="w-full h-72 lg:h-full object-cover">

                @else

                    <div class="w-full h-72 lg:h-full min-h-[280px]
                                bg-slate-50 flex items-center justify-center">

                        <div class="text-center">

                            <i class="bi bi-building text-6xl text-slate-300"></i>

                            <p class="text-sm text-slate-400 mt-2">
                                No project image
                            </p>

                        </div>

                    </div>

                @endif

            </div>


            {{-- Basic Info --}}
            <div class="lg:col-span-2 p-6">

                <div class="flex flex-wrap items-center gap-2 mb-5">

                    @php
                        $statusClasses = [
                            'planning' => 'bg-purple-50 text-purple-700',
                            'ongoing' => 'bg-blue-50 text-blue-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'on_hold' => 'bg-yellow-50 text-yellow-700',
                            'cancelled' => 'bg-red-50 text-red-700',
                        ];
                    @endphp

                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                 {{ $statusClasses[$project->status] ?? 'bg-slate-100 text-slate-700' }}">

                        {{ ucwords(str_replace('_', ' ', $project->status)) }}

                    </span>


                    @php
                        $shareClasses = [
                            'available' => 'bg-green-50 text-green-700',
                            'limited' => 'bg-yellow-50 text-yellow-700',
                            'sold_out' => 'bg-red-50 text-red-700',
                            'closed' => 'bg-slate-100 text-slate-700',
                        ];
                    @endphp

                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                 {{ $shareClasses[$project->share_status] ?? 'bg-slate-100 text-slate-700' }}">

                        Share:
                        {{ ucwords(str_replace('_', ' ', $project->share_status)) }}

                    </span>


                    @php
                        $workingClasses = [
                            'not_started' => 'bg-slate-100 text-slate-700',
                            'ongoing' => 'bg-blue-50 text-blue-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'on_hold' => 'bg-yellow-50 text-yellow-700',
                        ];
                    @endphp

                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                 {{ $workingClasses[$project->working_status] ?? 'bg-slate-100 text-slate-700' }}">

                        Working:
                        {{ ucwords(str_replace('_', ' ', $project->working_status)) }}

                    </span>

                </div>


                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $project->project_name }}
                </h2>

                <p class="text-slate-500 mt-1">
                    {{ $project->project_type ?: 'Real Estate Project' }}
                </p>


                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mt-6">


                    <div>

                        <p class="text-xs text-slate-500">
                            Company
                        </p>

                        <p class="font-medium text-slate-800 mt-1">
                            {{ $project->company->name ?? '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-500">
                            Branch
                        </p>

                        <p class="font-medium text-slate-800 mt-1">
                            {{ $project->branch->name ?? '—' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-500">
                            Project Code
                        </p>

                        <p class="font-medium text-slate-800 mt-1">
                            {{ $project->project_code }}
                        </p>

                    </div>


                    <div>

                        <p class="text-xs text-slate-500">
                            Project Size
                        </p>

                        <p class="font-medium text-slate-800 mt-1">
                            {{ $project->size ?: '—' }}
                        </p>

                    </div>


                    <div class="sm:col-span-2">

                        <p class="text-xs text-slate-500">
                            Location
                        </p>

                        <p class="font-medium text-slate-800 mt-1">
                            {{ $project->location ?: '—' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Timeline --}}
    <div class="bg-white border border-slate-200 rounded-xl">

        <div class="px-5 py-4 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                Project Timeline
            </h2>

        </div>


        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6">


            <div>

                <p class="text-xs text-slate-500">
                    Start Date
                </p>

                <p class="font-medium text-slate-800 mt-1">

                    {{ $project->start_date
                        ? $project->start_date->format('d M Y')
                        : '—'
                    }}

                </p>

            </div>


            <div>

                <p class="text-xs text-slate-500">
                    Expected Completion
                </p>

                <p class="font-medium text-slate-800 mt-1">

                    {{ $project->expected_completion_date
                        ? $project->expected_completion_date->format('d M Y')
                        : '—'
                    }}

                </p>

            </div>

        </div>

    </div>


    {{-- Key Highlights --}}
    <div class="bg-white border border-slate-200 rounded-xl">

        <div class="px-5 py-4 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                Key Highlights
            </h2>

        </div>


        <div class="p-5">

            @if($project->key_highlights)

                <div class="text-sm text-slate-600 whitespace-pre-line">
                    {{ $project->key_highlights }}
                </div>

            @else

                <p class="text-sm text-slate-400">
                    No key highlights added.
                </p>

            @endif

        </div>

    </div>


    {{-- Description --}}
    <div class="bg-white border border-slate-200 rounded-xl">

        <div class="px-5 py-4 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                Description
            </h2>

        </div>


        <div class="p-5">

            @if($project->description)

                <div class="text-sm text-slate-600 whitespace-pre-line">
                    {{ $project->description }}
                </div>

            @else

                <p class="text-sm text-slate-400">
                    No description added.
                </p>

            @endif

        </div>

    </div>


    {{-- System Information --}}
    <div class="bg-white border border-slate-200 rounded-xl">

        <div class="px-5 py-4 border-b border-slate-200">

            <h2 class="font-semibold text-slate-800">
                System Information
            </h2>

        </div>


        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-6">


            <div>

                <p class="text-xs text-slate-500">
                    Created At
                </p>

                <p class="font-medium text-slate-800 mt-1">

                    {{ $project->created_at
                        ? $project->created_at->format('d M Y h:i A')
                        : '—'
                    }}

                </p>

            </div>


            <div>

                <p class="text-xs text-slate-500">
                    Last Updated
                </p>

                <p class="font-medium text-slate-800 mt-1">

                    {{ $project->updated_at
                        ? $project->updated_at->format('d M Y h:i A')
                        : '—'
                    }}

                </p>

            </div>

        </div>

    </div>

</div>

@endsection