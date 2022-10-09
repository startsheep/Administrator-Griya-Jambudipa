<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherDevelop extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'develop_name',
        'develop_price',
    ];
}
