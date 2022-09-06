<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'customer_id', 'type', 'house_type_id', 'commission'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function paymentPrice()
    {
        return $this->hasMany(PaymentPrice::class, 'payment_id');
    }

    public function houseType()
    {
        return $this->hasOne(HouseType::class, 'id', 'house_type_id');
    }
}
