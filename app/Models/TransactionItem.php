<?php
// app/Models/TransactionItem.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $primaryKey = 'transaction_item_id';
    protected $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'order_type', 
        'order_id',
        'amount'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

    // Polymorphic relation ke Rental atau Buy
    public function order()
    {
        return $this->morphTo('order', 'order_type', 'order_id');
    }
}