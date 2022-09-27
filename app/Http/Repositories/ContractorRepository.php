<?php

namespace App\Http\Repositories;

use App\Http\Repositories\Contracts\ContractorContract;
use App\Http\Repositories\BaseRepository;
use App\Http\Services\Searches\ContractorSearch;
use App\Models\Contractor;
use App\Models\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ContractorRepository implements ContractorContract
{
    /** @var Contractor */
    protected $contractor;

    public function __construct(Contractor $contractor)
    {
        $this->contractor = $contractor;
    }

    public function all($request)
    {
        $factory = app()->make(ContractorSearch::class);
        $result = $factory->apply()->with(['document'])->paginate($request->per_page);

        return $result;
    }

    public function store(array $attributes): Collection
    {
        if (isset($attributes['image'])) {
            if (isset($attributes['image']) && $attributes['image']) {
                $attributes['image'] = $attributes['image']->store('contractor');
            }
        }

        $result = $this->contractor->create($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penambahan data pada pemborong'
        ]);

        return collect([
            'message' => 'success',
            'type' => 'success',
            'data' => $result,
            'status' => 200
        ]);
    }

    public function find($id): Contractor
    {
        return $this->contractor->with(['document'])->findOrFail($id);
    }

    public function update(array $attributes, $result)
    {
        if (isset($attributes['image'])  && $attributes['image']) {
            if (isset($attributes['image']) && $attributes['image']) {
                if ($result->image != null) {
                    Storage::delete($result->image);
                }
                $attributes['image'] = $attributes['image']->store('contractor');
            }
        }

        $result->update($attributes);

        if (isset($attributes['documents'])) {
            if (isset($attributes['documents']) && $attributes['documents']) {
                if ($result->document) {
                    foreach ($result->document as $document) {
                        Storage::delete($document->document_path);
                        $result->document()->delete();
                    }
                }
                $this->multipleUpload($attributes['documents'], $result);
            }
        }

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan perubahan data pada pemborong'
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

        if ($result->image != null) {
            Storage::delete($result->image);
        }

        Log::create([
            'id' => Str::uuid(),
            'user_id' => auth()->user()->id,
            'description' => auth()->user()->name . ' melakukan penghapusan data pada pemborong'
        ]);

        return $result->delete();
    }

    public function updateStatus(array $attributes, $result)
    {
        $result->status = $attributes['active'] ? 1 : 2;
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

    protected function storageFile($file, $folder)
    {
        $path = $file->store($folder);
        return $path;
    }

    protected function multipleUpload($files, $model)
    {
        foreach ($files as $file) {
            $document = $this->storageFile($file, 'document_contractor');
            $request['document_path'] = $document;
            $request['document_name'] = $file->getClientOriginalName();
            $model->document()->create($request);
        }
    }
}
