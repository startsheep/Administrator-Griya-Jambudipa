<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kavling_id',
        'name',
        'email',
        'phone',
        'profession',
        'gender',
        'image',
        'address',
    ];

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function kavling()
    {
        return $this->morphMany(CustomerKavling::class, 'customerable');
    }
}
