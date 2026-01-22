<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class responsiple extends Model
{
    use HasFactory;
    protected $table = 'responsiples';
    protected $fillable = [
        'name',
        'email',
        'gender',
        'phone',
        'address',
        'countable_id',
        'user_id',
    ];
    public function countable()
    {
        return $this->belongsTo(countable::class, 'countable_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
