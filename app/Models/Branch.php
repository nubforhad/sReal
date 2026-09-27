<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'phone',
        'email',
        'address',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
    ];
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}