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
        'creater_id',
        'group_category_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function groupCategory()
    {
        return $this->belongsTo(groupcategories::class);
    }
    
   
}
