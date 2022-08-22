<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerKavling extends Model
{
    use HasFactory;

    protected $fillable = ['kavling_id', 'customerable_id', 'customerable_type'];

    public function customerable()
    {
        return $this->morphTo();
    }
}
