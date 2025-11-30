<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'checked_out_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'checked_out_at' => 'datetime',
    ];

    // RELATION: Cart has many CartItems
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // RELATION: Cart belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
