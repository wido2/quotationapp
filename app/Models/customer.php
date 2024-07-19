<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'email', 'phone_number'];
    public function addresses(){
        return $this->hasMany(Address::class);
         // assuming Address model has a foreign key 'customer_id'  // Eloquent Relationship
    }
    public function orders(){
        return $this->hasMany(Order::class);
         // assuming Order model has a foreign key 'customer_id'  // Eloquent Relationship
    }
}
