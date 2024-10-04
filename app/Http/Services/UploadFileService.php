<?php

namespace App\Http\Services;

use App\Models\Image;
use Couchbase\InvalidRangeException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadFileService
{
    private IRandomStringGenerator $randomStringGenerator;
    private int $length;

    public function __construct(IRandomStringGenerator $randomStringGenerator, $length)
    {
        $this->randomStringGenerator = $randomStringGenerator;
        $this->length = $length;
    }

    public function setImage(
        UploadedFile $uploadedFile,
        Model        $model,
        string       $property,
        string       $disk
    ): void
    {

        $filename = $this->randomStringGenerator->generateRandomString($this->length)
            . '.' . $uploadedFile->getClientOriginalExtension();
        $image = new Image([
            'original_filename' => $uploadedFile->getClientOriginalName(),
            'disk' => $disk,
            'filename' => $filename
        ]);
        Storage::disk($disk)
            ->putFileAs('', $uploadedFile, $image->getFullFilename());
        $image->save();

        if ($model->$property) {
            $model->$property->delete();
        }

        $model->{$property . '_id'} = $image->id;
    }
}
