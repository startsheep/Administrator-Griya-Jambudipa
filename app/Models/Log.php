<?php

namespace App\Models;

use App\Http\Services\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory, Uuid;

    protected $fillable = ['id', 'user_id', 'description'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
