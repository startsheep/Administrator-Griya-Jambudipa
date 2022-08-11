<?php

namespace App\Http\Services\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Observers\PostObserver;
use DB;
use Carbon\Carbon;

trait EntryBy
{
    public static function bootEntryBy()
    {
        static::observe(PostObserver::class);
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function entryBy()
    {
        return isset($this->creator) ? $this->creator->name : '[System]';
    }

    public function entryAt()
    {
        return isset($this->created_at) && $this->created_at != NULL ? ($this->created_at->format('d F Y')) : '-';
    }
}
