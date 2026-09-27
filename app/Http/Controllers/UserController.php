<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['company', 'branch', 'roles'])
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->company_id, function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })->when($request->branch_id, function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })->latest()->paginate(15)->withQueryString();
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->orderBy('name')->get();
        return view('admin.users.index', compact( 'users', 'companies', 'branches'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();
        return view('admin.users.create', compact(
            'companies',
            'branches',
            'roles'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'company_id' => [
                'nullable',
                'exists:companies,id',
            ],

            'branch_id' => [
                'nullable',
                'exists:branches,id',
            ],

            'role' => [
                'required',
                'exists:roles,name',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Branch must belong to selected company
        |--------------------------------------------------------------------------
        */
        if (!empty($validated['branch_id'])) {
            $branchBelongsToCompany = Branch::where('id', $validated['branch_id'])
                ->where('company_id', $validated['company_id'])
                ->exists();

            if (!$branchBelongsToCompany) {
                return back()->withInput()->withErrors([
                        'branch_id' => 'Selected branch does not belong to the selected company.',
                    ]);
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'company_id' => $validated['company_id'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
            'status' => $validated['status'],
        ]);
        $user->assignRole($validated['role']);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load([
            'company',
            'branch',
            'roles',
        ]);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $companies = Company::where('status', true)->orderBy('name')->get();
        $branches = Branch::where('status', true)->with('company')->orderBy('name')->get();
        $roles = Role::where('guard_name', 'web')->orderBy('name')->get();
        $userRole = $user->roles->first()?->name;
        return view('admin.users.edit', compact(
            'user',
            'companies',
            'branches',
            'roles',
            'userRole'
        ));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'company_id' => [
                'nullable',
                'exists:companies,id',
            ],

            'branch_id' => [
                'nullable',
                'exists:branches,id',
            ],

            'role' => [
                'required',
                'exists:roles,name',
            ],

            'status' => [
                'required',
                'boolean',
            ],
        ]);

        if (!empty($validated['branch_id'])) {
            $branchBelongsToCompany = Branch::where('id', $validated['branch_id'])
                ->where('company_id', $validated['company_id'])
                ->exists();

            if (!$branchBelongsToCompany) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'branch_id' => 'Selected branch does not belong to the selected company.',
                    ]);
            }
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company_id' => $validated['company_id'] ?? null,
            'branch_id' => $validated['branch_id'] ?? null,
            'status' => $validated['status'],
        ];
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }
        $user->update($data);
        $user->syncRoles([$validated['role']]);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}