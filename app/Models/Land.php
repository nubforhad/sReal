<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Land extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'land_code',
        'land_name',
        'district',
        'upazila',
        'mouza',
        'khatian_no',
        'dag_no',
        'jl_no',
        'total_land_size',
        'land_unit',
        'owner_name',
        'owner_phone',
        'owner_nid',
        'purchase_price',
        'purchase_date',
        'status',
        'description',
        'remarks',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_land_size' => 'decimal:4',
        'purchase_price' => 'decimal:2',
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
}