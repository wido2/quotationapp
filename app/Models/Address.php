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
        // 'order_id',
        'address',
        'city',
        'state',
         'country',
         'zip_code',
         'type',  // Home, Office, etc.
         'is_default'];
     public function customer(){
        return $this->belongsTo(Customer::class);
         // assuming Customer model has a foreign key 'customer_id'  // Eloquent Relationship
    }
    // public function order(){
    //     return $this->belongsTo(Order::class);
    //      // assuming Order model has a foreign key 'order_id'  // Eloquent Relationship
    // }

}
