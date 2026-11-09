<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConstructionCost extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'building_id',
        'client_id',
        'receipt_no',
        'building_client_assignment_id',
        'construction_cost_category_id',

        // Cost Information
        'cost_date',
        'payment_date',
        'amount',
        'description',
        'document',

        // Money Receipt Information
        'purpose',
        'payment_method',
        'cheque_no',
        'bank_name',
        'bank_branch',
        'amount_words',

        // User
        'created_by',
    ];

    protected $casts = [
        'cost_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(
            BuildingClientAssignment::class,
            'building_client_assignment_id'
        );
    }
 
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            ConstructionCostCategory::class,
            'construction_cost_category_id'
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
