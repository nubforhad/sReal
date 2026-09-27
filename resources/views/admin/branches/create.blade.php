@extends('admin.layouts.app')

@section('title', 'Add Branch')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">
    {{-- Header --}}
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-500">
            <a href="{{ route('admin.branches.index') }}"
               class="hover:text-blue-600">
                Branches
            </a>
            <i class="bi bi-chevron-right text-xs"></i>
            <span>Add Branch</span>
        </div>
        <h1 class="mt-2 text-2xl font-bold text-slate-800">
            Add Branch
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Create a new branch under a company.
        </p>
    </div>
    {{-- Errors --}}
    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Form --}}
    <form action="{{ route('admin.branches.store') }}"  method="POST"  class="rounded-xl border border-slate-200 bg-white shadow-sm">
        @csrf
        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-800">
                Branch Information
            </h2>
        </div>
        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
            {{-- Company --}}
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Company
                    <span class="text-red-500">*</span>
                </label>
                <select name="company_id"
                        required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">
                        Select Company
                    </option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}"
                            {{ old('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }} ({{ $company->code }})
                        </option>
                    @endforeach
                </select>
                @error('company_id')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Branch Name --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Branch Name
                    <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       placeholder="Enter branch name"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Code --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Branch Code
                    <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="code"
                       value="{{ old('code') }}"
                       required
                       placeholder="Example: DHAKA01"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:ring-blue-500">
                @error('code')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Phone --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Phone
                </label>
                <input type="text"  name="phone"
                       value="{{ old('phone') }}"
                       placeholder="01XXXXXXXXX"
                       class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                @error('phone')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Email --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Email
                </label>
                <input type="email"  name="email" value="{{ old('email') }}" placeholder="branch@example.com" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                @error('email')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Status --}}
            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Status
                    <span class="text-red-500">*</span>
                </label>
                <select name="status" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="1"
                        {{ old('status', '1') == '1' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="0"
                        {{ old('status') === '0' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- Address --}}
            <div class="md:col-span-2">
                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Address
                </label>
                <textarea name="address"  rows="4"  placeholder="Enter branch address" class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('address') }}</textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
            <a href="{{ route('admin.branches.index') }}"  class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                <i class="bi bi-check-lg"></i>
                Save Branch
            </button>
        </div>
    </form>
</div>

@endsection