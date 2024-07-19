<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id',
    'quantity', 'unit_price', 'total_price',
    'discount'];
    public function order(){
        return $this->belongsTo(Order::class);
         // assuming Order model has a foreign key 'order_id'  // Eloquent Relationship
    }
    public function product(){
        return $this->belongsTo(Product::class);
         // assuming Product model has a foreign key 'product_id'  // Eloquent Relationship
    }
    public function uom(){
        return $this->belongsTo(Uom::class);
         // assuming Uom model has a foreign key 'uom_id'  // Eloquent Relationship
    }
    public function pajak(){
        return $this->belongsTo(Pajak::class);
         // assuming Pajak model has a foreign key 'pajak_id'  // Eloquent Relationship
    }
    

}
