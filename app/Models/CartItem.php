<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'user_id',
        'quantity',
        'unit_price',
        'line_total',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    // RELATION: CartItem belongs to a Cart
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    // RELATION: CartItem belongs to a Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // RELATION: CartItem belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
