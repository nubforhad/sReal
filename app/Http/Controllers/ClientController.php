<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with([
                'company',
                'branch',
                'project',
            ])
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('client_code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('nid', 'like', "%{$search}%");
                });
            })
            ->when($request->company_id, function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })
            ->when($request->branch_id, function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })
            ->when($request->project_id, function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::with(['company', 'branch'])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ])
            ->latest()
            ->get();

        return view('admin.clients.index', compact(
            'clients',
            'companies',
            'branches',
            'projects'
        ));
    }

    public function create()
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::with(['company', 'branch'])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ])
            ->orderBy('project_name')
            ->get();

        return view('admin.clients.create', compact(
            'companies',
            'branches',
            'projects'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'father_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'mother_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'spouse_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'alternate_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'nid_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'other_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            // Nominee
            'nominee_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nominee_relation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'nominee_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'nominee_nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nominee_address' => [
                'nullable',
                'string',
            ],

            'nominee_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'nominee_nid_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'nominee_other_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        // Branch must belong to selected company
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

        // Project must belong to selected company and branch
        $projectBelongsToBranch = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->exists();

        if (!$projectBelongsToBranch) {
            return back()
                ->withInput()
                ->withErrors([
                    'project_id' => 'Selected project does not belong to the selected company and branch.',
                ]);
        }

        DB::transaction(function () use ($request, $validated) {

            /*
             * First create with temporary code.
             * After getting the auto increment ID,
             * generate final Client ID.
             */
            $client = Client::create([
                'company_id' => $validated['company_id'],
                'branch_id' => $validated['branch_id'],
                'project_id' => $validated['project_id'],

                'client_code' => 'TEMP-' . uniqid(),

                'name' => $validated['name'],
                'father_name' => $validated['father_name'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
                'spouse_name' => $validated['spouse_name'] ?? null,

                'phone' => $validated['phone'],
                'alternate_phone' => $validated['alternate_phone'] ?? null,
                'email' => $validated['email'] ?? null,

                'nid' => $validated['nid'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'occupation' => $validated['occupation'] ?? null,

                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,

                'nominee_name' => $validated['nominee_name'] ?? null,
                'nominee_relation' => $validated['nominee_relation'] ?? null,
                'nominee_phone' => $validated['nominee_phone'] ?? null,
                'nominee_nid' => $validated['nominee_nid'] ?? null,
                'nominee_address' => $validated['nominee_address'] ?? null,

                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Generate Client ID
            $client->update([
                'client_code' => 'RE-' . now()->format('Y') . '-' . str_pad(
                    $client->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);

            // Client photo
            if ($request->hasFile('photo')) {
                $client->update([
                    'photo' => $request->file('photo')
                        ->store('clients/photos', 'public'),
                ]);
            }

            // Client NID document
            if ($request->hasFile('nid_document')) {
                $client->update([
                    'nid_document' => $request->file('nid_document')
                        ->store('clients/nid', 'public'),
                ]);
            }

            // Client other document
            if ($request->hasFile('other_document')) {
                $client->update([
                    'other_document' => $request->file('other_document')
                        ->store('clients/documents', 'public'),
                ]);
            }

            // Nominee photo
            if ($request->hasFile('nominee_photo')) {
                $client->update([
                    'nominee_photo' => $request->file('nominee_photo')
                        ->store('clients/nominees/photos', 'public'),
                ]);
            }

            // Nominee NID document
            if ($request->hasFile('nominee_nid_document')) {
                $client->update([
                    'nominee_nid_document' => $request->file('nominee_nid_document')
                        ->store('clients/nominees/nid', 'public'),
                ]);
            }

            // Nominee other document
            if ($request->hasFile('nominee_other_document')) {
                $client->update([
                    'nominee_other_document' => $request->file('nominee_other_document')
                        ->store('clients/nominees/documents', 'public'),
                ]);
            }
        });

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load([
            'company',
            'branch',
            'project',
        ]);

        return view('admin.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $companies = Company::where('status', true)
            ->orderBy('name')
            ->get();

        $branches = Branch::where('status', true)
            ->with('company')
            ->orderBy('name')
            ->get();

        $projects = Project::with(['company', 'branch'])
            ->whereIn('status', [
                'planning',
                'ongoing',
            ])
            ->orderBy('project_name')
            ->get();

        return view('admin.clients.edit', compact(
            'client',
            'companies',
            'branches',
            'projects'
        ));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'company_id' => [
                'required',
                'exists:companies,id',
            ],

            'branch_id' => [
                'required',
                'exists:branches,id',
            ],

            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'father_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'mother_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'spouse_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'alternate_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'occupation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'nid_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'other_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'nominee_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nominee_relation' => [
                'nullable',
                'string',
                'max:100',
            ],

            'nominee_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'nominee_nid' => [
                'nullable',
                'string',
                'max:50',
            ],

            'nominee_address' => [
                'nullable',
                'string',
            ],

            'nominee_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'nominee_nid_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'nominee_other_document' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        // Branch validation
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

        // Project validation
        $projectBelongsToBranch = Project::where('id', $validated['project_id'])
            ->where('company_id', $validated['company_id'])
            ->where('branch_id', $validated['branch_id'])
            ->exists();

        if (!$projectBelongsToBranch) {
            return back()
                ->withInput()
                ->withErrors([
                    'project_id' => 'Selected project does not belong to the selected company and branch.',
                ]);
        }

        DB::transaction(function () use ($request, $validated, $client) {

            $client->update([
                'company_id' => $validated['company_id'],
                'branch_id' => $validated['branch_id'],
                'project_id' => $validated['project_id'],

                'name' => $validated['name'],
                'father_name' => $validated['father_name'] ?? null,
                'mother_name' => $validated['mother_name'] ?? null,
                'spouse_name' => $validated['spouse_name'] ?? null,

                'phone' => $validated['phone'],
                'alternate_phone' => $validated['alternate_phone'] ?? null,
                'email' => $validated['email'] ?? null,

                'nid' => $validated['nid'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'occupation' => $validated['occupation'] ?? null,

                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,

                'nominee_name' => $validated['nominee_name'] ?? null,
                'nominee_relation' => $validated['nominee_relation'] ?? null,
                'nominee_phone' => $validated['nominee_phone'] ?? null,
                'nominee_nid' => $validated['nominee_nid'] ?? null,
                'nominee_address' => $validated['nominee_address'] ?? null,

                'status' => $validated['status'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Replace client photo
            if ($request->hasFile('photo')) {

                if ($client->photo) {
                    Storage::disk('public')->delete($client->photo);
                }

                $client->update([
                    'photo' => $request->file('photo')
                        ->store('clients/photos', 'public'),
                ]);
            }

            // Replace NID document
            if ($request->hasFile('nid_document')) {

                if ($client->nid_document) {
                    Storage::disk('public')->delete($client->nid_document);
                }

                $client->update([
                    'nid_document' => $request->file('nid_document')
                        ->store('clients/nid', 'public'),
                ]);
            }

            // Replace other document
            if ($request->hasFile('other_document')) {

                if ($client->other_document) {
                    Storage::disk('public')->delete($client->other_document);
                }

                $client->update([
                    'other_document' => $request->file('other_document')
                        ->store('clients/documents', 'public'),
                ]);
            }

            // Replace nominee photo
            if ($request->hasFile('nominee_photo')) {

                if ($client->nominee_photo) {
                    Storage::disk('public')->delete($client->nominee_photo);
                }

                $client->update([
                    'nominee_photo' => $request->file('nominee_photo')
                        ->store('clients/nominees/photos', 'public'),
                ]);
            }

            // Replace nominee NID
            if ($request->hasFile('nominee_nid_document')) {

                if ($client->nominee_nid_document) {
                    Storage::disk('public')->delete($client->nominee_nid_document);
                }

                $client->update([
                    'nominee_nid_document' => $request->file('nominee_nid_document')
                        ->store('clients/nominees/nid', 'public'),
                ]);
            }

            // Replace nominee other document
            if ($request->hasFile('nominee_other_document')) {

                if ($client->nominee_other_document) {
                    Storage::disk('public')->delete($client->nominee_other_document);
                }

                $client->update([
                    'nominee_other_document' => $request->file('nominee_other_document')
                        ->store('clients/nominees/documents', 'public'),
                ]);
            }
        });

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        // Delete all client files
        $files = [
            $client->photo,
            $client->nid_document,
            $client->other_document,
            $client->nominee_photo,
            $client->nominee_nid_document,
            $client->nominee_other_document,
        ];

        foreach ($files as $file) {
            if ($file) {
                Storage::disk('public')->delete($file);
            }
        }

        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Client deleted successfully.');
    }
} 
