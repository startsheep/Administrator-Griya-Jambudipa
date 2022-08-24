<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Contracts\AccountContract;
use App\Http\Requests\Account\AccountCreateRequest;
use App\Http\Requests\Account\AccountUpdateRequest;
use App\Http\Requests\Account\ChangePasswordRequest;
use App\Http\Resources\Account\AccountCollection;
use App\Http\Resources\Account\AccountDetail;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $account;

    public function __construct(AccountContract $account)
    {
        $this->account = $account;
    }

    public function index(Request $request)
    {
        $result = $this->account->all($request);

        return new AccountCollection($result);
    }

    public function store(AccountCreateRequest $request)
    {
        $result = $this->account->store($request->all());

        return response()->json([
            'message' => 'success',
            'data' => $result
        ]);
    }

    public function show($id)
    {
        $result = $this->account->find($id);

        return new AccountDetail($result);
    }

    public function update(AccountUpdateRequest $request, $id)
    {
        $result = $this->account->find($id);

        $data = $this->account->update($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function delete($id)
    {
        $result = $this->account->find($id);
        $this->account->delete($result);

        return new AccountDetail($result);
    }

    public function changePassword(ChangePasswordRequest $request, $id)
    {
        $result = $this->account->find($id);

        $data = $this->account->changePassword($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }

    public function changeStatus(Request $request, $id)
    {
        $result = $this->account->find($id);

        $data = $this->account->changeStatus($request->all(), $result);
        $output = $data;
        return response()->json(
            [
                'message' => $output['message'],
                'type' => $output['type'],
                'result' => $output['data']
            ],
            $output['status']
        );
    }
}
