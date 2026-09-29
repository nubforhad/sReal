<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandShareSale extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'land_id',
        'client_id',
        'sale_code',
        'sale_date',
        'share_size',
        'share_unit',
        'price_per_unit',
        'land_share_price',
        'status',
        'remarks',
    ];
    protected $casts = [
        'sale_date' => 'date',
        'share_size' => 'decimal:4',
        'price_per_unit' => 'decimal:2',
        'land_share_price' => 'decimal:2',
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
    public function land(): BelongsTo
    {
        return $this->belongsTo(Land::class);
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}