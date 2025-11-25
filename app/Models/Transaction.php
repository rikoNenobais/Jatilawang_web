<?php
// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id';
    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'total_amount', 
        'payment_method',
        'payment_status',
        'payment_proof',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id', 'transaction_id');
    }

    public function rentals()
    {
        return $this->hasManyThrough(
            Rental::class,
            TransactionItem::class,
            'transaction_id',
            'rental_id',
            'transaction_id',
            'order_id'
        )->where('transaction_items.order_type', 'rental');
    }

    public function buys()
    {
        return $this->hasManyThrough(
            Buy::class,
            TransactionItem::class,
            'transaction_id', 
            'buy_id',
            'transaction_id',
            'order_id'
        )->where('transaction_items.order_type', 'buy');
    }
}