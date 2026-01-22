<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'amount',
        'color',
        'stock_id',
        'creater_id',
        'group_category_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'creater_id');
    }
    public function groupCategory()
    {
        return $this->belongsTo(group_categories::class, 'group_category_id');
    }
    public function stock()
    {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}
