<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $table = 'delivery_items';

    protected $fillable = [
        'delivery_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
