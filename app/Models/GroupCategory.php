<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<<< HEAD:app/Models/groupcategories.php
class groupcategories extends Model
========
class GroupCategory extends Model
>>>>>>>> dedede9ba2d43cb20cc791c5f318c5debe04449b:app/Models/GroupCategory.php
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
<<<<<<<< HEAD:app/Models/groupcategories.php
   
      public function category()
========
    public function category()
>>>>>>>> dedede9ba2d43cb20cc791c5f318c5debe04449b:app/Models/GroupCategory.php
    {
        return $this->belongsTo(Category::class);
    }
}
