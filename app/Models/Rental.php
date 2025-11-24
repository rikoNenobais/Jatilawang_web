<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $primaryKey = 'rental_id';
    public $incrementing = true;

    protected $fillable = [
        'user_id', 
        'rental_start_date', 
        'rental_end_date',
        'return_date', 
        'total_price',
        // FIELD BARU SESUAI MIGRATION
        'payment_method',
        'payment_status',
        'order_status', 
        'delivery_option',
        'payment_proof',
        'identity_file',
        'identity_type',
        'shipping_address',
        'paid_at'
        // TIDAK ADA delivery_fee - SESUAI MIGRATION
    ];

    protected $dates = ['rental_start_date', 'rental_end_date', 'return_date'];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function details()
    {
        return $this->hasMany(DetailRental::class, 'rental_id', 'rental_id');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'detail_rentals', 'rental_id', 'item_id')
                    ->withPivot('quantity', 'penalty'); 
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'rental_id', 'rental_id');
    }
}