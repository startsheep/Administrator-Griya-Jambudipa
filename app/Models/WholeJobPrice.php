<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholeJobPrice extends Model
{
    use HasFactory;

    protected $fillable = ['whole_job_id', 'price'];

    public function wholeJob()
    {
        return $this->belongsTo(WholeJob::class);
    }
}
