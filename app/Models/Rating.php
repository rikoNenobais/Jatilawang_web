<?php
// app/Models/Rating.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'rating_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'item_id', 
        'rental_id',
        'buy_id',
        'transaction_id',
        'rating_value',
        'comment'
    ];

    protected $casts = [
        'rating_value' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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

    // Relasi ke Rental
    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

    // Relasi ke Buy
    public function buy()
    {
        return $this->belongsTo(Buy::class, 'buy_id', 'buy_id');
    }

    // Relasi ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    // Scope untuk mencari rating berdasarkan type
    public function scopeForRental($query, $rentalId)
    {
        return $query->where('rental_id', $rentalId);
    }

    public function scopeForBuy($query, $buyId)
    {
        return $query->where('buy_id', $buyId);
    }

    public function scopeForItem($query, $itemId)
    {
        return $query->where('item_id', $itemId);
    }
}