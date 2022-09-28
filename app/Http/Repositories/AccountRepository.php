<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\AccountContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\AccountSearch;
use App\Http\Services\Traits\SendEmail;
use App\Models\Account;
use App\Models\Log;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AccountRepository implements AccountContract
{
    use SendEmail;

    /** @var User */
    protected $account;

    protected $ROLE_ID_USER;

    protected $STATUS_USER_ACTIVE;

    protected $STATUS_USER_NO_ACTIVE;

    protected $DOCUMENTABLE_TYPE;

    public function __construct(User $account)
    {
        $this->account = $account;
        $this->ROLE_ID_USER = 2;
        $this->STATUS_USER_ACTIVE = 1;
        $this->STATUS_USER_NO_ACTIVE = 0;
        $this->DOCUMENTABLE_TYPE = "App\Models\Account";
    }

    public function all($request)
    {
        $factory = app()->make(AccountSearch::class);
        $accounts = $factory->apply()->with('document')->paginate($request->per_page);

        return $accounts;
    }

    public function store(array $attributes): User
    {
        $roleId = $this->ROLE_ID_USER;

        $attributes['password'] = Str::random(8);
        $attributes['is_active'] = $this->STATUS_USER_NO_ACTIVE;
        $attributes['email_verified_at'] = now();

        if (isset($attributes['role_id'])) {
            $roleId = $attributes['role_id'];
        }

        $role = Role::find($roleId);

        $result = $this->account->create($attributes);
        $result->syncRoles($role);

        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['document_path'] = $attributes['image']->store('user');
                $attributes['document_name'] = $attributes['image']->getClientOriginalName();

                $result->document()->create($attributes);
            }
        }

        if ($result) {
            $this->sendEmail($attributes['email'], $attributes['password']);
        }


        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada pengguna'
        ]);

        return $result;
    }

    public function find($id): User
    {
        return $this->account->with('document')->findOrFail($id);
    }

    public function findByCriteria(array $criteria): User
    {
        return $this->account
            ->where($criteria)->with('image')
            ->first();
    }

    public function update(array $attributes, $result)
    {
        $roleId = $this->ROLE_ID_USER;

        $result->update($attributes);

        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                if ($result->image) {
                    Storage::delete($result->image->document_path);

                    $result->document()->delete();
                }

                $path = $attributes['image']->store('user');
                $name = $attributes['image']->getClientOriginalName();

                $result->document()->create([
                    'documentable_id' => $result->id,
                    'documentable_type' => $this->DOCUMENTABLE_TYPE,
                    'document_path' => $path,
                    'document_name' => $name
                ]);
            }
        }

        if (isset($attributes['role_id'])) {
            $roleId = $attributes['role_id'];
        }

        $role = Role::find($roleId);
        $result->syncRoles($role);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan perubahan data pada pengguna'
        ]);

        return collect([
            'message' => 'success',
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function delete($result)
    {
        if ($result->id != 1) {
            if ($result->image?->document_path) {
                Storage::delete($result->image->document_path);
            }

            $result->image()->delete();
            $result->delete();
        }

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penghapusan data pada pengguna'
        ]);

        return $result;
    }

    public function changePassword(array $attributes, $result)
    {
        $checkPassword = Hash::check($attributes['old_password'], $result->password);
        if (!$checkPassword) {
            return collect([
                'message' => 'password lama tidak cocok!',
                'type' => 'error',
                'data' => [],
                'status' => 400
            ]);
        }

        $attributes['password'] = $attributes['new_password'];

        $result->update($attributes);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' merubah password'
        ]);

        return collect([
            'message' => 'success',
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function changeStatus(array $attributes, $result)
    {
        $result->is_active = $attributes['active'] ? $this->STATUS_USER_ACTIVE : $this->STATUS_USER_NO_ACTIVE;
        $result->save();

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' merubah status ' . $result->name
        ]);

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }
}
