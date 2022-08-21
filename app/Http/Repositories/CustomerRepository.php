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
        $employees = $factory->apply()->with(['document', 'kavling'])->paginate($request->per_page);

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
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

        return $result;
    }

    public function find($id): Customer
    {
        return $this->customer->with(['document', 'kavling'])->find($id);
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
                foreach ($result->document as $document) {
                    Storage::delete($document->document_path);
                    $result->document()->delete();
                }
                $this->multipleUpload($attributes['documents'], $result);
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
        if (count($result->document) > 0) {
            foreach ($result->document as $document) {
                Storage::delete($document->document_path);
            }

            $result->document()->delete();
        }

        if ($result->image != null) {
            Storage::delete($result->image);
        }

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
            $request['document_path'] = $document;
            $request['document_name'] = $file->getClientOriginalName();
            $model->document()->create($request);
        }
    }
}
