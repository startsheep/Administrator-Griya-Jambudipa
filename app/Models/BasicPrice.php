<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'id',
        'basic_price_category_id',
        'parent_id',
        'unit',
        'volume',
        'amount',
        'price',
        'total',
        'description',
    ];

    public function basicPriceCategory()
    {
        return $this->hasOne(BasicPriceCategory::class, 'id', 'basic_price_category_id');
    }

    public function parent()
    {
        return $this->hasOne(BasicPrice::class, 'id', 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(BasicPrice::class, 'parent_id');
    }
}
