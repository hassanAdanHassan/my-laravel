<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'creater_id',
        'product_id',
    ];  
    public function products()
    {
        return $this->hasMany(products::class,'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,"creater_id");
    }
}
