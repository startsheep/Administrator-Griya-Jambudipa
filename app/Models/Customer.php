<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kavling_id',
        'name',
        'email',
        'phone',
        'profession',
        'gender',
        'image',
        'address',
    ];

    public function documentCustomer()
    {
        return $this->hasMany(DocumentCustomer::class, 'customer_id', 'id');
    }

    public function kavling()
    {
        return $this->hasOne(Kavling::class, 'id', 'kavling_id');
    }
}
