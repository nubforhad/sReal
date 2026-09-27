@extends('admin.layouts.app')

@section('title', 'Add Project')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center
                sm:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Add Project
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Create a new company and branch-wise project.
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


    {{-- Form --}}
    <form action="{{ route('admin.projects.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf


        {{-- Basic Information --}}
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
                                {{ old('company_id') == $company->id ? 'selected' : '' }}>

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
                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>

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
                           value="{{ old('project_code') }}"
                           required
                           placeholder="e.g. PRJ-001"
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
                           value="{{ old('project_name') }}"
                           required
                           placeholder="Project name"
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
                           value="{{ old('project_type') }}"
                           placeholder="Residential / Commercial / Land"
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
                           value="{{ old('size') }}"
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
                              placeholder="Project location / address"
                              class="w-full rounded-lg border-slate-200
                                     focus:border-blue-500 focus:ring-blue-500">{{ old('location') }}</textarea>

                </div>
                {{-- Image --}}
                <div class="md:col-span-2">

                    <label class="block text-sm font-medium  text-slate-700 mb-1.5">
                        Project Image
                    </label>
                    <input type="file"
                           name="image"
                           accept="image/jpeg,image/png,image/jpg,image/webp"
                           class="w-full rounded-lg border border-slate-200
                                  bg-white px-3 py-2 text-sm">

                    <p class="text-xs text-slate-500 mt-1">
                        JPG, JPEG, PNG or WEBP. Maximum 2MB.
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
                              placeholder="Write important project highlights..."
                              class="w-full rounded-lg border-slate-200
                                     focus:border-blue-500 focus:ring-blue-500">{{ old('key_highlights') }}</textarea>
                </div>
            </div>
        </div>
        {{-- Date & Status --}}
        <div class="bg-white border border-slate-200 rounded-xl">

            <div class="px-5 py-4 border-b border-slate-200">

                <h2 class="font-semibold text-slate-800">
                    Project Status & Timeline
                </h2>
            </div>
            <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Start Date --}}
                <div>
                    <label class="block text-sm font-medium  text-slate-700 mb-1.5">
                        Start Date
                    </label>
                    <input type="date"
                           name="start_date"
                           value="{{ old('start_date') }}"
                           class="w-full rounded-lg border-slate-200
                                  focus:border-blue-500 focus:ring-blue-500">
                </div>
                {{-- Expected Completion --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">   Expected Completion Date
                    </label>
                    <input type="date" name="expected_completion_date" value="{{ old('expected_completion_date') }}" class="w-full rounded-lg border-slate-200  focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium  text-slate-700 mb-1.5">
                        Project Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'planning' => 'Planning',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'on_hold' => 'On Hold',
                            'cancelled' => 'Cancelled',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('status', 'planning') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5"> Share Status <span class="text-red-500">*</span>
                    </label>
                    <select name="share_status" required class="w-full rounded-lg border-slate-200  focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'available' => 'Available',
                            'limited' => 'Limited',
                            'sold_out' => 'Sold Out',
                            'closed' => 'Closed',
                        ] as $value => $label)

                            <option value="{{ $value }}"
                                {{ old('share_status', 'available') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium  text-slate-700 mb-1.5">  Working Status <span class="text-red-500">*</span>
                    </label>
                    <select name="working_status" required   class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">

                        @foreach([
                            'not_started' => 'Not Started',
                            'ongoing' => 'Ongoing',
                            'completed' => 'Completed',
                            'on_hold' => 'On Hold',
                        ] as $value => $label)
                            <option value="{{ $value }}"
                                {{ old('working_status', 'not_started') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">
                        Description
                    </label>
                    <textarea name="description" rows="5" placeholder="Project description..." class="w-full rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>
        {{-- Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.projects.index') }}"
               class="px-5 py-2.5 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 rounded-lg text-sm font-medium">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                <i class="bi bi-check-lg"></i>
                Save Project
            </button>
        </div>
    </form>
</div>

@endsection