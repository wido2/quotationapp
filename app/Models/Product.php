<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_category_id','product_brand_id','name','price','description','quantity','is_active'];
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

}
