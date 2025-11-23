<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'cart_item_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'item_id', 
        'type',
        'quantity',
        'days'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'days' => 'integer'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    // Helper methods
    public function isRental()
    {
        return $this->type === 'rent';
    }

    public function isPurchase()
    {
        return $this->type === 'buy';
    }

    // Calculate total price
    public function getTotalPriceAttribute()
    {
        if ($this->isRental()) {
            $dailyPrice = $this->item->rental_price_per_day ?? 0;
            return $dailyPrice * $this->days * $this->quantity;
        } else {
            $salePrice = $this->item->sale_price ?? 0;
            return $salePrice * $this->quantity;
        }
    }

    // Calculate price per unit
    public function getUnitPriceAttribute()
    {
        if ($this->isRental()) {
            return $this->item->rental_price_per_day ?? 0;
        } else {
            return $this->item->sale_price ?? 0;
        }
    }
}