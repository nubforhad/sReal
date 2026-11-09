<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\BuildingClientAssignment;
use App\Models\ConstructionCost;
use App\Models\ConstructionCostCategory;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConstructionCostController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Company & Branch Scope
    |--------------------------------------------------------------------------
    */
 

    private function scope($query)
    {
        $user = auth()->user();

        return $query
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )
            ->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */

    private function projects()
    {
        $user = auth()->user();

        return Project::query()
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )
            ->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            )
            ->orderBy('project_name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Active Building Client Assignments
    |--------------------------------------------------------------------------
    */

    private function assignments()
    {
        return $this->scope(
            BuildingClientAssignment::with([
                'building',
                'client',
                'project',
            ])->where('status', 'active')
        )->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Active Cost Categories
    |--------------------------------------------------------------------------
    */

    private function categories()
    {
        return $this->scope(
            ConstructionCostCategory::where('status', 'active')
        )->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Construction Payments / Money Receipts
    |--------------------------------------------------------------------------
    */

    private function costs()
    {
        return $this->scope(
            ConstructionCost::with([
                'company',
                'branch',
                'project',
                'building',
                'client',
                'assignment',
                'category',
                'creator',
            ])
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Unique Receipt Number
    |--------------------------------------------------------------------------
    */

    private function generateReceiptNo(): string
    {
        do {
            $receiptNo = 'SCG-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (
            ConstructionCost::where('receipt_no', $receiptNo)->exists()
        );

        return $receiptNo;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Payment / Receipt Information
    |--------------------------------------------------------------------------
    */

    private function validateCost(Request $request): array
    {
        $data = $request->validate([

            // Project & Building
            'project_id' => [
                'required',
                'integer',
                'exists:projects,id',
            ],

            'building_id' => [
                'required',
                'integer',
                'exists:buildings,id',
            ],

            'building_client_assignment_id' => [
                'required',
                'integer',
                'exists:building_client_assignments,id',
            ],

            // Cost Category
            'construction_cost_category_id' => [
                'required',
                'integer',
                'exists:construction_cost_categories,id',
            ],

            // Dates
            'cost_date' => [
                'required',
                'date',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            // Amount
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999999999.99',
            ],

            // Money Receipt Information
            'purpose' => [
                'required',
                'in:Booking,Down Payment,Installment,Others',
            ],

            'payment_method' => [
                'required',
                'in:Cash,RTGS,NPSB,EFTN,PO,Online,Cheque',
            ],

            'cheque_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'bank_branch' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount_words' => [
                'nullable',
                'string',
                'max:500',
            ],

            // Other Information
            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'document' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'max:5120',
            ],
        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Validate Project Access
        |--------------------------------------------------------------------------
        */

        $project = Project::query()
            ->whereKey($data['project_id'])
            ->when($user->company_id, fn ($q) =>
                $q->where('company_id', $user->company_id)
            )
            ->when($user->branch_id, fn ($q) =>
                $q->where('branch_id', $user->branch_id)
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Validate Building
        |--------------------------------------------------------------------------
        */

        $building = Building::query()
            ->whereKey($data['building_id'])
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Validate Assigned Client
        |--------------------------------------------------------------------------
        */

        $assignment = BuildingClientAssignment::query()
            ->whereKey($data['building_client_assignment_id'])
            ->where('building_id', $building->id)
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->where('status', 'active')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Validate Category
        |--------------------------------------------------------------------------
        */

        $category = ConstructionCostCategory::query()
            ->whereKey($data['construction_cost_category_id'])
            ->where('project_id', $project->id)
            ->where('company_id', $project->company_id)
            ->where('branch_id', $project->branch_id)
            ->where('status', 'active')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Set Database Values
        |--------------------------------------------------------------------------
        */

        $data['company_id'] = $project->company_id;
        $data['branch_id'] = $project->branch_id;
        $data['project_id'] = $project->id;
        $data['building_id'] = $building->id;

        // Client ID comes from selected active assignment
        $data['client_id'] = $assignment->client_id;

        $data['building_client_assignment_id'] = $assignment->id;

        // Creator
        $data['created_by'] = $user->id;

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = $this->costs();

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->filled('building_id')) {
            $query->where('building_id', $request->building_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        if ($request->filled('receipt_no')) {
            $query->where('receipt_no', 'like', '%' . $request->receipt_no . '%');
        }

        $costs = $query
            ->latest('payment_date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.construction-costs.index', [
            'costs' => $costs,
            'projects' => $this->projects(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.construction-costs.create', [
            'projects' => $this->projects(),
            'assignments' => $this->assignments(),
            'categories' => $this->categories(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Store Payment & Generate Money Receipt
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $data = $this->validateCost($request);

        // Generate receipt number automatically
        $data['receipt_no'] = $this->generateReceiptNo();

        // Store document
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')
                ->store('construction-costs', 'public');
        }

        ConstructionCost::create($data);

        return redirect()
            ->route('admin.construction-costs.index')
            ->with('success', 'Payment received and Money Receipt created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();

        return view('admin.construction-costs.show', compact('cost'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()->whereKey($constructionCost->id)->firstOrFail();

        return view('admin.construction-costs.edit', [
            'cost' => $cost,
            'projects' => $this->projects(),
            'assignments' => $this->assignments(),
            'categories' => $this->categories(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();

        $data = $this->validateCost($request);

        // Do not change original receipt number
        unset($data['created_by']);

        if (empty($cost->receipt_no)) {
            $data['receipt_no'] = $this->generateReceiptNo();
        } else {
            unset($data['receipt_no']);
        }

        if ($request->hasFile('document')) {

            if ($cost->document) {
                Storage::disk('public')->delete($cost->document);
            }

            $data['document'] = $request->file('document')
                ->store('construction-costs', 'public');

        } else {
            unset($data['document']);
        }

        $cost->update($data);

        return redirect()
            ->route('admin.construction-costs.index')
            ->with('success', 'Payment and Money Receipt updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function destroy(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();

        if ($cost->document) {
            Storage::disk('public')->delete($cost->document);
        }

        $cost->delete();

        return redirect()
            ->route('admin.construction-costs.index')
            ->with('success', 'Payment record deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Print Money Receipt
    |--------------------------------------------------------------------------
    */

    public function print(ConstructionCost $constructionCost)
    {
        $cost = $this->costs()
            ->whereKey($constructionCost->id)
            ->firstOrFail();

        return view('admin.construction-costs.print', compact('cost'));
    }
}
