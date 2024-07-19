<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','description','logo_path','is_active'];
    public function products(){
        return $this->hasMany(Product::class);
         // assuming Product model has a foreign key 'product_brand_id'  // Eloquent Relationship
    }

    
}
