<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'customer_id', 'type', 'kavling_id', 'commission'  , "discount"];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function paymentPrice()
    {
        return $this->hasMany(PaymentPrice::class, 'payment_id');
    }

    public function kavling()
    {
        return $this->hasOne(Kavling::class, 'id', 'kavling_id');
    }

    public function otherDevelop()
    {
        return $this->hasOne(OtherDevelop::class, 'payment_id', 'id');
    }

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
