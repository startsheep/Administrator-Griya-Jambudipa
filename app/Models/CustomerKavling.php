<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerKavling extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'kavling_id'];

    public function kavling()
    {
        return $this->hasOne(Kavling::class, 'id', 'kavling_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
