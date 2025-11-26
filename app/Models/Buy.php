<?php
// app/Models/Buy.php
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
        'order_status',
        'delivery_option',
        'shipped_at'
        // TIDAK ADA payment fields lagi
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

    // Relasi ke transaction items
    public function transactionItems()
    {
        return $this->morphMany(TransactionItem::class, 'order', 'order_type', 'buy_id');
    }

    // Relasi ke transaction
    public function transaction()
    {
        return $this->hasOneThrough(
            Transaction::class,
            TransactionItem::class,
            'order_id', // FK di transaction_items
            'transaction_id', // FK di transactions
            'buy_id', // PK di buys
            'transaction_id' // FK di transaction_items
        )->where('transaction_items.order_type', 'buy');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'buy_id', 'buy_id');
    }
}