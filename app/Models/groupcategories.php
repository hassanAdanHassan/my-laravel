<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class groupcategories extends Model

{
    use HasFactory;
    protected $table = 'group_categories';
    protected $fillable = [
        'name',
        'category_id',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    public function category()

    {
        return $this->belongsTo(Category::class);
    }
}
