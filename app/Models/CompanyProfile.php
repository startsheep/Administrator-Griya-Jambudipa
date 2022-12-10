<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    const STATIC_ID = 1;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'url',
        'address',
        'logo',
    ];
}
