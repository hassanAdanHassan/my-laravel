<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class group_categories extends Model
{
    use HasFactory;
    protected $table = 'group_categories';
    protected $fillable = [
        'name',
        'category_id',
        'user_id',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
