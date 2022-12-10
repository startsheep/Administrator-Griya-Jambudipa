<?php

namespace App\Http\Services\Traits;

trait MessageFixer
{
  protected function successMessage($message = '')
  {
    if ($message) {
      return response()->json([
        'message' => $message,
        'type' => 'success'
      ]);
    }

    return response()->json([
      'message' => 'success',
      'type' => 'success'
    ]);
  }
}
