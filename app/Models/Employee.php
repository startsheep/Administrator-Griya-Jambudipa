<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'referal_code',
        'position_id',
        'name',
        'email',
        'phone',
        'gender',
        'address',
        'entry_date',
        'image',
        'status',
        'is_active',
    ];

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }

    public function document()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
