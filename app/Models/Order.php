<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded ='';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function order_statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function pending_order()
    {
        return $this->hasMany(OrderStatus::class)->where('order_status','pending')->latest();
    }
    public function latest_status()
    {
        return $this->hasOne('App\Models\OrderStatus')->latest();
    }
}
