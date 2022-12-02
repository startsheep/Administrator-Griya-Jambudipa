<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_type',
        'block',
        'number_kavling',
        'width_kavling',
        'length_kavling',
        'second_length_kavling',
        'area_kavling',
        'area_building'
    ];

    public function customerKavling()
    {
        return $this->belongsTo(CustomerKavling::class, 'id', 'kavling_id');
    }

    public function houseType()
    {
        return $this->belongsTo(HouseType::class, 'id', 'kavling_id');
    }
}
