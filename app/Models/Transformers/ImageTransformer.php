<?php

namespace App\Models\Transformers;

use App\Models\Image;
use Flugg\Responder\Transformers\Transformer;

class ImageTransformer extends Transformer
{
    protected $relations = [
        'image' => ImageTransformer::class,
        ];

    public function transform(Image $model): array
    {
        return [
                'filename' => $model->original_filename,
                'src' => $model->src,
        ] ;
    }

}
