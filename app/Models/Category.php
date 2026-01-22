<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'category_id',
        'creater_id',
    ];
    public function groupCategories()
    {
        return $this->hasMany(GroupCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'creater_id');
    }
}
