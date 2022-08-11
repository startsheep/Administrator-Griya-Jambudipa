<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\UserContract;
use App\Http\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserContract
{
	/** @var User */
	protected $user;

	public function __construct(User $user)
	{
		parent::__construct($user);
		$this->user = $user;
	}

	public function customRules()
	{
		return;
	}

    public function store(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);
        $attributes['role_id'] = 2;
        $attributes['is_active'] = 1;

        if ($attributes['image']) {
            $attributes['image'] = $attributes['image']->store('public/users');
            $attributes['image'] = url('') . '/' . str_replace('public', 'storage', $attributes['image']);
        }

        return $this->user->create($attributes);
    }
}
