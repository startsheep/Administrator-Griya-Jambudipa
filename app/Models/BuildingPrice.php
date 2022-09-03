<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'building_price_category_id',
        'parent_id',
        'unit',
        'volume',
        'amount',
        'price',
        'total',
        'description',
    ];

    public function buildingPriceCategory()
    {
        return $this->hasOne(BuildingPriceCategory::class, 'id', 'building_price_category_id');
    }

    public function parent()
    {
        return $this->hasOne(BuildingPrice::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(BuildingPrice::class, 'parent_id');
    }
}
