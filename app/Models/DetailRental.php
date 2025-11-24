<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailRental extends Model
{
    protected $primaryKey = 'rental_detail_id';
    public $table = 'detail_rentals';

    protected $fillable = [
        'rental_id', 
        'item_id', 
        'quantity', 
        'penalty'
    ];

    // Relasi
    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id', 'rental_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}