<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'unit',
        'volume',
        'amount',
        'price',
        'total',
        'description',
    ];

    public function parent()
    {
        return $this->hasOne(Tickets::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Tickets::class, 'parent_id');
    }
}
