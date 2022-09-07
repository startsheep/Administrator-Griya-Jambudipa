<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicPriceCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'section'];

    public function basicPrice()
    {
        return $this->hasMany(BasicPrice::class, 'basic_price_category_id', 'id');
    }
}
