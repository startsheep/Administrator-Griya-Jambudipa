<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\CustomerContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\CustomerSearch;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerRepository implements CustomerContract
{
    /** @var Customer */
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function all($request)
    {
        $factory = app()->make(CustomerSearch::class);
        $employees = $factory->apply()->with('documentCustomer')->paginate($request->per_page);

        return $employees;
    }

    public function store(array $attributes): Customer
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['image'] = $this->storageFile($attributes['image'], 'customer');
            }
        }

        $result = $this->customer->create($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                $attributes['documents'] = $this->multipleUpload($attributes['documents'], $result);
            }
        }

        return $result;
    }

    public function find($id): Customer
    {
        return $this->customer->with('documentCustomer')->find($id);
    }

    public function update(array $attributes, $result)
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                Storage::delete($result->image);
                $attributes['image'] = $this->storageFile($attributes['image'], 'customer');
            }
        }

        $result->update($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                foreach ($result->documentCustomer as $document) {
                    Storage::delete($document->document);
                    $result->documentCustomer()->delete();
                }
                $attributes['documents'] = $this->multipleUpload($attributes['documents'], $result);
            }
        }

        return collect([
            'message' => "success",
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function delete($result)
    {
        if (count($result->documentCustomer) > 0) {
            foreach ($result->documentCustomer as $document) {
                Storage::delete($document->document);
            }

            $result->documentCustomer()->delete();
        }

        Storage::delete($result->image);

        $result->delete();

        return $result->delete();
    }

    protected function storageFile($file, $folder)
    {
        $path = $file->store($folder);
        return $path;
    }

    protected function multipleUpload($files, $model)
    {
        foreach ($files as $file) {
            $document = $this->storageFile($file, 'document_customer');
            $request['document'] = $document;
            $request['customer_id'] = $model->id;
            $model->documentCustomer()->create($request);
        }
    }
}
