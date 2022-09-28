<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholeJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'customer_id',
        'house_type_id',
        'payment_type',
        'description',
        'total_cost',
        'start_date',
        'end_date',
        'type'
    ];

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function wholeJobPrice()
    {
        return $this->hasMany(WholeJobPrice::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }

    public function houseType()
    {
        return $this->hasOne(HouseType::class, 'id', 'house_type_id');
    }
}
