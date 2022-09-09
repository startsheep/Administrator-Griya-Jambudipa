<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'company_name',
        'phone',
        'email',
        'pic_name',
        'address',
        'image',
        'status',
    ];

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
