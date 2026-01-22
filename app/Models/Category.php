<?php

namespace App\Models;

use App\Models\groupcategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'category_id',
        'creater_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
public function groupCategory()
    {
        return $this->belongsTo(groupcategories::class, 'category_id');
    }
}
