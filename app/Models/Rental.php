<?php
// app/Models/Rental.php
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
        'order_status', 
        'delivery_option',
        'identity_file',
        'identity_type',
        'shipping_address'
        // TIDAK ADA payment fields lagi
    ];

    protected $dates = ['rental_start_date', 'rental_end_date', 'return_date'];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke detail rentals
    public function details()
    {
        return $this->hasMany(DetailRental::class, 'rental_id', 'rental_id');
    }

    // Relasi ke items melalui detail
    public function items()
    {
        return $this->belongsToMany(Item::class, 'detail_rentals', 'rental_id', 'item_id')
                    ->withPivot('quantity', 'penalty'); 
    }

    // Relasi ke transaction items
    public function transactionItems()
    {
        return $this->morphMany(TransactionItem::class, 'order', 'order_type', 'rental_id');
    }

    // Relasi ke transaction
    public function transaction()
    {
        return $this->hasOneThrough(
            Transaction::class,
            TransactionItem::class,
            'order_id', // FK di transaction_items
            'transaction_id', // FK di transactions
            'rental_id', // PK di rentals
            'transaction_id' // FK di transaction_items
        )->where('transaction_items.order_type', 'rental');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'rental_id', 'rental_id');
    }
}