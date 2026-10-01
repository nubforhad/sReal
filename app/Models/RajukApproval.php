<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RajukApproval extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',

        'application_no',
        'applicant_name',
        'applicant_phone',

        'plot_number',
        'road_number',
        'block',
        'mouza',
        'land_area',

        'plan_type',
        'number_of_floors',
        'number_of_flats',
        'architect_name',
        'consultant_name',

        'application_date',
        'submission_date',
        'approval_date',

        'approval_number',
        'status',
        'remarks',

        'plan_document',
        'approval_document',
    ];

    protected $casts = [
        'application_date' => 'date',
        'submission_date' => 'date',
        'approval_date' => 'date',

        'number_of_floors' => 'integer',
        'number_of_flats' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}