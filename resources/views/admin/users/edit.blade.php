@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Edit User
            </h1>

            <p class="text-sm text-slate-500">
                Update user information, access and role.
            </p>
        </div>

        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- Basic Information --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5">

                <h2 class="mb-5 text-lg font-semibold text-slate-800">
                    Basic Information
                </h2>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- Name --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Name <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Email <span class="text-red-500">*</span>
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            New Password
                        </label>

                        <input type="password"
                               name="password"
                               autocomplete="new-password"
                               placeholder="Leave blank to keep current password"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Confirm New Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               autocomplete="new-password"
                               placeholder="Confirm new password"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>

                </div>

            </div>

            {{-- Access --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5">

                <h2 class="mb-5 text-lg font-semibold text-slate-800">
                    Access Information
                </h2>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- Company --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Company
                        </label>

                        <select name="company_id"
                                id="company_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                            <option value="">Select Company</option>

                            @foreach($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('company_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Branch --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Branch
                        </label>

                        <select name="branch_id"
                                id="branch_id"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                            <option value="">Select Branch</option>

                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}"
                                        data-company="{{ $branch->company_id }}"
                                    {{ old('branch_id', $user->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                    — {{ $branch->company->name ?? '' }}
                                </option>
                            @endforeach

                        </select>

                        @error('branch_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Role <span class="text-red-500">*</span>
                        </label>

                        <select name="role"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                            <option value="">Select Role</option>

                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $userRole) == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach

                        </select>

                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700">
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select name="status"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">

                            <option value="1" {{ old('status', $user->status ? '1' : '0') == '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ old('status', $user->status ? '1' : '0') == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>
                    </div>

                </div>

            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    <i class="bi bi-check-lg"></i>
                    Update User
                </button>

            </div>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
    const companySelect = document.getElementById('company_id');
    const branchSelect = document.getElementById('branch_id');

    function filterBranches() {

        const companyId = companySelect.value;

        Array.from(branchSelect.options).forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = option.dataset.company !== companyId;

        });

        if (branchSelect.selectedOptions.length &&
            branchSelect.selectedOptions[0].hidden) {

            branchSelect.value = '';
        }
    }

    companySelect.addEventListener('change', filterBranches);

    filterBranches();
</script>

@endpush