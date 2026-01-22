<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'country',
        'province',
        'district',
        'village',
        'zoon',
        'state',
    ];
    function user()
    {
        return $this->belongsTo(User::class, 'creater_id');
    }
}
