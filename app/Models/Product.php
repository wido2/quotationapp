<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_category_id',
        'slug',
        'product_brand_id',
        'name',
        'price',
        'description',
        'stock',
        'is_active',
        'uom_id'
    ];
    public function productBrand(){
        return $this->belongsTo(ProductBrand::class);
    }
    public function productCategory(){
        return $this->belongsTo(ProductCategory::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
         // assuming OrderItem model has a foreign key 'product_id'  // Eloquent Relationship

    }
    public function Uom(){
        return $this->belongsTo(Uom::class,);
         // assuming Uom model has a foreign key 'uom_id'  // Eloquent Relationship
    }

}
