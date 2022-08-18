<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
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
}
