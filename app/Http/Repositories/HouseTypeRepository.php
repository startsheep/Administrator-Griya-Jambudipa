<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\HouseTypeContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\HouseTypeSearch;
use App\Models\HouseType;
use Illuminate\Support\Facades\Storage;

class HouseTypeRepository implements HouseTypeContract
{
    /** @var HouseType */
    protected $houseType;

    public function __construct(HouseType $houseType)
    {
        $this->houseType = $houseType;
    }

    public function all($request)
    {
        $factory = app()->make(HouseTypeSearch::class);
        $houseTypes = $factory->apply()->with(['document'])->paginate($request->per_page);

        return $houseTypes;
    }

    public function store(array $attributes): HouseType
    {
        $result = $this->houseType->create($attributes);

        if (isset($attributes['images'])) {
            if (isset($attributes['images']) && $attributes['images']) {
                $this->multipleUpload($attributes['images'], $result);
            }
        }

        return $result;
    }

    public function find($id): HouseType
    {
        return $this->houseType->with(['document'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        if (isset($attributes['images'])) {
            if (isset($attributes['images']) && $attributes['images']) {
                foreach ($result->document as $document) {
                    Storage::delete($document->document_path);
                    $result->document()->delete();
                }
                $this->multipleUpload($attributes['images'], $result);
            }
        }

        $result->update($attributes);

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
            $document = $this->storageFile($file, 'document_house_type');
            $request['document_path'] = $document;
            $request['document_name'] = $file->getClientOriginalName();
            $model->document()->create($request);
        }
    }
}
