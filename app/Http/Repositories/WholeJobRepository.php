<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\WholeJobContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\WholeJobSearch;
use App\Models\WholeJob;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class WholeJobRepository implements WholeJobContract
{
    /** @var WholeJob */
    protected $wholeJob;

    public function __construct(WholeJob $wholeJob)
    {
        $this->wholeJob = $wholeJob;
    }

    public function all($request)
    {
        $factory = app()->make(WholeJobSearch::class);
        $result = $factory->apply()->with(['document', 'customer', 'contractor', 'houseType'])->paginate($request->per_page);

        return $result;
    }

    public function store(array $attributes): Collection
    {
        $result = $this->wholeJob->create($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

        return collect([
            'message' => 'success',
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function find($id): WholeJob
    {
        return $this->wholeJob->with(['document', 'customer', 'contractor', 'houseType'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
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
            'message' => 'success',
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
