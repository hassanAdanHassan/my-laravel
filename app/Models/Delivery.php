<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';

    protected $fillable = [
        'customer_id',
        'creater_id',
        'destination',
        'status',
        'in_transit_at',
        'delivered_at',
        'cancelled_at',
    ];

    protected $casts = [
        'in_transit_at' => 'datetime',
        'delivered_at'  => 'datetime',
        'cancelled_at'  => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creater_id');
    }

    public function items()
    {
        return $this->hasMany(DeliveryItem::class);
    }

    public function isEditable(): bool
    {
        return $this->status === 'pending';
    }

    public function isFinal(): bool
    {
        return in_array($this->status, ['delivered', 'cancelled']);
    }
}
