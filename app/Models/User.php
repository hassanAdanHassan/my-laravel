<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Authenticatable implements AuthenticatableContract

{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'name',
        'roles',
        'email',
         'password',
    ];
       public function categories()
    {
        return $this->hasMany(Category::class, 'creater_id');
    }
    public function group_categories()
    {
        return $this->hasMany(group_categories::class, 'creater_id');
    }
    public function countables()
    {
        return $this->hasMany(countability::class, 'user_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class, 'user_id'); 
    }
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'user_id');
    // }
    public function products()
    {
        return $this->hasMany(products::class, 'creater_id');
    }
    public function suppliers()
    {
        return $this->hasMany(suppliers::class, 'creater_id');
    }
    
}
