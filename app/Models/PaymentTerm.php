<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    public function orders(){
        return $this->hasMany(Order::class);
         // assuming Order model has a foreign key 'payment_term_id'  // Eloquent Relationship
    }


}
