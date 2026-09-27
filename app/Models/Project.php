<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_code',
        'project_name',
        'project_type',
        'location',
        'size',
        'image',
        'key_highlights',
        'start_date',
        'expected_completion_date',
        'status',
        'share_status',
        'working_status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_completion_date' => 'date',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}