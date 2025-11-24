<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBuy extends Model
{
    protected $primaryKey = 'buy_detail_id';
    protected $table = 'detail_buys'; // SESUAIKAN DENGAN MIGRATION

    protected $fillable = [
        'buy_id', // SESUAIKAN DENGAN MIGRATION
        'item_id', 
        'quantity', 
        'total_price'
    ];

    // Relasi
    public function buy()
    {
        return $this->belongsTo(Buy::class, 'buy_id', 'buy_id'); // SESUAIKAN
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}