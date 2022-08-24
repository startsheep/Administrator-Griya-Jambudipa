<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kavling extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_type_id',
        'block',
        'number_kavling',
        'width_kavling',
        'length_kavling',
        'area_kavling',
        'area_building'
    ];

    public function customerKavling()
    {
        return $this->morphMany(CustomerKavling::class, 'kavlingable');
    }
}
