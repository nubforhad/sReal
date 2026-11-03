<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Building extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'rajuk_approval_id',
        'building_code',
        'building_name',
        'building_type',
        'number_of_floors',
        'number_of_basements',
        'total_flats',
        'construction_start_date',
        'expected_completion_date',
        'actual_completion_date',
        'contractor_name',
        'contractor_phone',
        'architect_name',
        'engineer_name',
        'status',
        'description',
        'building_image',
        'document',
    ];

    protected $casts = [
        'number_of_floors' => 'integer',
        'number_of_basements' => 'integer',
        'total_flats' => 'integer',
        'construction_start_date' => 'date',
        'expected_completion_date' => 'date',
        'actual_completion_date' => 'date',
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

    public function rajukApproval(): BelongsTo
    {
        return $this->belongsTo(RajukApproval::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(
            Client::class,
            'building_client_assignments'
        )->withPivot([
            'id',
            'company_id',
            'branch_id',
            'project_id',
            'assigned_at',
            'status',
            'remarks',
        ])->withTimestamps();
    }

}
