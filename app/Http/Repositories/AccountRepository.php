<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\AccountContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\AccountSearch;
use App\Http\Services\Traits\SendEmail;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountRepository implements AccountContract
{
    use SendEmail;

    /** @var Account */
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function all($request)
    {
        $factory = app()->make(AccountSearch::class);
        $accounts = $factory->apply()->with('document')->paginate($request->per_page);

        return $accounts;
    }

    public function store(array $attributes): Account
    {
        $attributes['password'] = Str::random(8);
        $attributes['is_active'] = 1;
        $attributes['email_verified_at'] = now();
        $result = $this->account->create($attributes);

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

        return $result;
    }

    public function find($id): Account
    {
        return $this->account->with('document')->findOrFail($id);
    }

    public function findByCriteria(array $criteria): Account
    {
        return $this->account
            ->where($criteria)->with('image')
            ->first();
    }

    public function update(array $attributes, $result)
    {
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
                    'documentable_type' => 'App\Models\Account',
                    'document_path' => $path,
                    'document_name' => $name
                ]);
            }
        }

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

        return collect([
            'message' => 'success',
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function changeStatus(array $attributes, $result)
    {
        $result->is_active = $attributes['active'] ? 1 : 2;
        $result->save();

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }
}
