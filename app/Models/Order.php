<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_no',
        'customer_id',
        'delivery_address',
        'invoice_address',
        'expiration',
        'payment_term_id',
        'user_id',
        'grand_total',
        'note',
        'status'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class);
         // assuming customer model has a foreign key 'customers_id'  // Eloquent Relationship
    }

    public function paymentTerm(){
        return $this->belongsTo(PaymentTerm::class);
         // assuming PaymentTerm model has a foreign key 'payment_term_id'  // Eloquent Relationship
    }
    public function user(){
        return $this->belongsTo(User::class);
         // assuming User model has a foreign key 'user_id'  // Eloquent Relationship
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class,);
         // assuming OrderItem model has a foreign key 'order_id'  // Eloquent Relationship
    }
    public function product(){
        return $this->belongsTo(Product::class);
         // assuming Product model has a foreign key 'product_id'  // Eloquent Relationship
    }


    public function address():HasOne{
        return $this->hasOne(Address::class,'id');
         // assuming Address model has a foreign key 'order_id'  // Eloquent Relationship
    }

}
