<?php

namespace App\Http\Services\Traits;

use Illuminate\Support\Str;
use App\Models\Log as ModelsLog;

trait Log
{
  protected function createLog($message)
  {
    ModelsLog::create([
      'id' => Str::uuid(),
      'user_id' => auth()->user()->id,
      'description' => auth()->user()->name . ' ' . $message,
    ]);
  }
}
