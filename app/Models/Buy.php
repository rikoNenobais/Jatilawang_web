<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    protected $primaryKey = 'buy_id';
    protected $table = 'buys';

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'payment_method',
        'payment_status', 
        'order_status',
        'delivery_option',
        'payment_proof',
        'paid_at',
        'shipped_at'
    ];

    // Relasi ke detail buys
    public function detailBuys()
    {
        return $this->hasMany(DetailBuy::class, 'buy_id', 'buy_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}