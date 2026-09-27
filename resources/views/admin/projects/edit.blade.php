@extends('admin.layouts.app')

@section('title', 'Edit Project')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center
                sm:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Edit Project
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Update project information.
            </p>

        </div>

        <a href="{{ route('admin.projects.index') }}"
           class="inline-flex items-center justify-center gap-2
                  px-4 py-2.5 border border-slate-200
                  bg-white hover:bg-slate-50
                  text-slate-700 rounded-lg text-sm font-medium">

            <i class="bi bi-arrow-left"></i>

            Back

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="bg-red-50 border border-red-200
                    text-red-700 px-4 py-3 rounded-lg">

            <ul class="list-disc list-inside text-sm space-y-1">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form action="{{ route('admin.projects.update', $project) }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf
        @method('PUT')


        {{-- Project Information --}}
        <div class="bg-white border border-slate-200 rounded-xl">

            <div class="px-5 py-4 border-b border-slate-200">

                <h2 class="font-semibold text-slate-800">
                    Project Information
                </h2>

            </div>


            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Company --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Company <span class="text-red-500">*</span>

                    </label>

                    <select name="company_id"
                            required
                            class="w-full rounded-lg border-slate-200
                                   focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Select Company
                        </option>

                        @foreach($companies as $company)

                            <option value="{{ $company->id }}"
                                {{ old('company_id', $project->company_id) == $company->id ? 'selected' : '' }}>

                                {{ $company->name }}

                            </option>

                        @endforeach

                    </select>

                    @error('company_id')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Branch --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Branch <span class="text-red-500">*</span>

                    </label>

                    <select name="branch_id"
                            required
                            class="w-full rounded-lg border-slate-200
                                   focus:border-blue-500 focus:ring-blue-500">

                        <option value="">
                            Select Branch
                        </option>

                        @foreach($branches as $branch)

                            <option value="{{ $branch->id }}"
                                {{ old('branch_id', $project->branch_id) == $branch->id ? 'selected' : '' }}>

                                {{ $branch->name }}
                                — {{ $branch->company->name ?? '' }}

                            </option>

                        @endforeach

                    </select>

                    @error('branch_id')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Project Code --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Project Code <span class="text-red-500">*</span>

                    </label>

                    <input type="text"
                           name="project_code"
                           value="{{ old('project_code', $project->project_code) }}"
                           required
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                    @error('project_code')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Project Name --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Project Name <span class="text-red-500">*</span>

                    </label>

                    <input type="text"
                           name="project_name"
                           value="{{ old('project_name', $project->project_name) }}"
                           required
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                    @error('project_name')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Project Type --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Project Type

                    </label>

                    <input type="text"
                           name="project_type"
                           value="{{ old('project_type', $project->project_type) }}"
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                </div>


                {{-- Size --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Project Size

                    </label>

                    <input type="text"
                           name="size"
                           value="{{ old('size', $project->size) }}"
                           placeholder="e.g. 10 Bigha / 5 Acre"
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                    @error('size')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Location --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Location

                    </label>

                    <textarea name="location"
                              rows="3"
                              class="w-full rounded-lg border-slate-200
                                     focus:border-blue-500 focus:ring-blue-500">{{ old('location', $project->location) }}</textarea>

                </div>


                {{-- Current Image --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-2">

                        Current Project Image

                    </label>

                    @if($project->image)

                        <img src="{{ asset('storage/' . $project->image) }}"
                             alt="{{ $project->project_name }}"
                             class="w-40 h-28 object-cover rounded-lg
                                    border border-slate-200 mb-3">

                    @else

                        <div class="w-40 h-28 rounded-lg bg-slate-50
                                    border border-slate-200
                                    flex items-center justify-center mb-3">

                            <i class="bi bi-image text-3xl text-slate-300"></i>

                        </div>

                    @endif


                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Change Image

                    </label>

                    <input type="file"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full rounded-lg border border-slate-200
                                  bg-white px-3 py-2 text-sm">

                    <p class="text-xs text-slate-500 mt-1">
                        Leave empty to keep the current image.
                        Maximum 2MB.
                    </p>

                    @error('image')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Key Highlights --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Key Highlights

                    </label>

                    <textarea name="key_highlights"
                              rows="5"
                              class="w-full rounded-lg border-slate-200
                                     focus:border-blue-500 focus:ring-blue-500">{{ old('key_highlights', $project->key_highlights) }}</textarea>

                </div>

            </div>

        </div>


        {{-- Status & Timeline --}}
        <div class="bg-white border border-slate-200 rounded-xl">

            <div class="px-5 py-4 border-b border-slate-200">

                <h2 class="font-semibold text-slate-800">
                    Project Status & Timeline
                </h2>

            </div>


            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">


                {{-- Start Date --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Start Date

                    </label>

                    <input type="date"
                           name="start_date"
                           value="{{ old('start_date', optional($project->start_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                </div>


                {{-- Expected Completion --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Expected Completion Date

                    </label>

                    <input type="date"
                           name="expected_completion_date"
                           value="{{ old('expected_completion_date', optional($project->expected_completion_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">

                </div>


                {{-- Status --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Project Status <span class="text-red-500">*</span>

                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-lg border-slate-200
                                   focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'planning' => 'Planning',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'on_hold' => 'On Hold',
                            'cancelled' => 'Cancelled',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('status', $project->status) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Share Status --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Share Status <span class="text-red-500">*</span>

                    </label>

                    <select name="share_status"
                            required
                            class="w-full rounded-lg border-slate-200
                                   focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'available' => 'Available',
                            'limited' => 'Limited',
                            'sold_out' => 'Sold Out',
                            'closed' => 'Closed',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('share_status', $project->share_status) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Working Status --}}
                <div>

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Working Status <span class="text-red-500">*</span>

                    </label>

                    <select name="working_status"
                            required
                            class="w-full rounded-lg border-slate-200
                                   focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'not_started' => 'Not Started',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'on_hold' => 'On Hold',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('working_status', $project->working_status) == $value ? 'selected' : '' }}>

                                {{ $label }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Description --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium
                                  text-slate-700 mb-1.5">

                        Description

                    </label>

                    <textarea name="description"
                              rows="5"
                              class="w-full rounded-lg border-slate-200
                                     focus:border-blue-500 focus:ring-blue-500">{{ old('description', $project->description) }}</textarea>

                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3">

            <a href="{{ route('admin.projects.index') }}"
               class="px-5 py-2.5 border border-slate-200
                      bg-white hover:bg-slate-50
                      text-slate-700 rounded-lg text-sm font-medium">

                Cancel

            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2
                           px-5 py-2.5 bg-blue-600 hover:bg-blue-700
                           text-white rounded-lg text-sm font-medium">

                <i class="bi bi-check-lg"></i>

                Update Project

            </button>

        </div>

    </form>

</div>

@endsection