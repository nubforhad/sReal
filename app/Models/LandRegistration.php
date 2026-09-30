<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandRegistration extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'land_share_sale_id',
        'client_id',
        'registration_code',
        'deed_no',
        'registration_date',
        'sub_registry_office',
        'district',
        'upazila',
        'mouza',
        'khatian_no',
        'dag_no',
        'jl_no',
        'registered_land_size',
        'land_unit',
        'registration_cost',
        'other_cost',
        'total_cost',
        'deed_document',
        'registration_document',
        'other_document',
        'status',
        'remarks',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'registered_land_size' => 'decimal:4',
        'registration_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
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
    public function landShareSale(): BelongsTo
    {
        return $this->belongsTo(LandShareSale::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}