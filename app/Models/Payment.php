<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'price'];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id');
    }
}
