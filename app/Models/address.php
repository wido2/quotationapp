<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class address extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'address',
     'city','state',  'country', 'zip_code','is_default'];
     public function customer(){
        return $this->belongsTo(customer::class);
         // assuming Customer model has a foreign key 'customer_id'  // Eloquent Relationship
    }
}
