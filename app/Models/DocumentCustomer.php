<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'document',
    ];
}
