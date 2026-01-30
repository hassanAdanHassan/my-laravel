<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class countability extends Model
{
    use HasFactory;
    protected $table = 'countabilities';
    protected $fillable = [
        'name',
        'org-country',
        'Lagel_NO',
        'Gender',
        'countable_id',
        'user_id',
    ];
   
   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
