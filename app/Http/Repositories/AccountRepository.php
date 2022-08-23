<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\AccountContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\AccountSearch;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class AccountRepository implements AccountContract
{
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
        $attributes['password'] = "password";
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

        return $result;
    }

    public function find($id): Account
    {
        return $this->account->with('document')->find($id);
    }

    public function update(array $attributes, $result)
    {
        $result->update($attributes);

        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                if ($result->image?->document_path) {
                    Storage::delete($result->image->document_path);
                }

                $path = $attributes['image']->store('user');
                $name = $attributes['image']->getClientOriginalName();

                $result->document()->update([
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
}
