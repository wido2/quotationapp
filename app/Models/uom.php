<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class uom extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
         // assuming OrderItem model has a foreign key 'uom_id'  // Eloquent Relationship
    }
}
