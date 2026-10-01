<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandSharePayment extends Model
{
    protected $fillable = [
        'company_id',
        'branch_id',
        'project_id',
        'land_share_sale_id',
        'client_id',
        'receipt_no',
        'payment_date',
        'amount',
        'payment_method',
        'transaction_no',
        'bank_name',
        'cheque_no',
        'remarks',
    ];

    protected $casts = [
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
 
    public function landShareSale(): BelongsTo
    {
        return $this->belongsTo(LandShareSale::class);
    }
 
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
 
}