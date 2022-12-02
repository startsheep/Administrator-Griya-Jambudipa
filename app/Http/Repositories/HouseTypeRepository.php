<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\HouseTypeContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\HouseTypeSearch;
use App\Models\HouseType;
use App\Models\Log;
use Illuminate\Support\Str;
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

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada tipe rumah'
        ]);

        return $result;
    }

    public function find($id): HouseType
    {
        return $this->houseType->with(['document'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        if ($result->document) {
            $dataFile = $result->document();
            if (isset($attributes['old_images'])) {
                $dataFile = $result->document()->whereNotIn('id', $attributes['old_images']);
            }
            $dataCek = $dataFile->get();
            foreach ($dataCek as $file) {
                if ($file->document_path) {
                    Storage::delete($file->document_path);

                }
            }
            $dataFile->delete();
        }

        if (isset($attributes['images']) && $attributes['images']) {
            $this->multipleUpload($attributes['images'], $result);
        }

        if (isset($attributes['old_images'])) {
            unset($attributes['old_images']);
        }


        $result->update($attributes);

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan perubahan data pada tipe rumah'
        ]);

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

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penghapusan data pada tipe rumah'
        ]);

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
