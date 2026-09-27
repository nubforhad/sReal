<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $fillable = [
        // Company / Branch / Project
        'company_id',
        'branch_id',
        'project_id',

        // Client Basic Information
        'client_code',
        'name',
        'father_name',
        'mother_name',
        'spouse_name',

        // Contact
        'phone',
        'alternate_phone',
        'email',

        // Personal Information
        'nid',
        'date_of_birth',
        'occupation',

        // Address
        'address',
        'city',

        // Client Documents
        'photo',
        'nid_document',
        'other_document',

        // Nominee Information
        'nominee_name',
        'nominee_relation',
        'nominee_phone',
        'nominee_nid',
        'nominee_address',

        // Nominee Documents
        'nominee_photo',
        'nominee_nid_document',
        'nominee_other_document',

        // Status / Remarks
        'status',
        'remarks',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
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
