<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
         // assuming OrderItem model has a foreign key 'uom_id'  // Eloquent Relationship
    }
    public function product(){
        return $this->hasMany(Product::class,);
         // assuming Product model has a foreign key 'uom_id'  // Eloquent Relationship

        }





}
