<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class groupCategory extends Model
{
    use HasFactory;
    protected $table = "group_categories";
    protected $fillable = [
        'name',
    ];
}
