<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPriceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category'];

    public function buildingPrice()
    {
        return $this->hasMany(BuildingPrice::class, 'building_price_category_id', 'id');
    }
}
