<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'address',
        'city',
        'state',
         'country',
         'zip_code',
         'is_default'];
     public function customer(){
        return $this->belongsTo(Customer::class);
         // assuming Customer model has a foreign key 'customer_id'  // Eloquent Relationship
    }
    
}
