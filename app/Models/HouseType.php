<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    use HasFactory;

    protected $fillable = [
        'kavling_id',
        'house_type',
        'description',
        'price'
    ];

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function kavling()
    {
        return $this->belongsTo(Kavling::class, 'id');
    }
}
