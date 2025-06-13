<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'address', 'city', 'state', 'zipcode', 'country'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

