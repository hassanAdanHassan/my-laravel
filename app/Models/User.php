<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements AuthenticatableContract

{
    
    use HasFactory;
    //trait 
    use Notifiable;
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
    public function groupcategories()
    {
        return $this->hasMany(groupcategories::class, 'creater_id');
    }
    public function countables()
    {
        return $this->hasMany(countability::class, 'user_id');
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
    
 return $this->hasMany(Suppliers::class, "creater_id"); 
 
 }
 }