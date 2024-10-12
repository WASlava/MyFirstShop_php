<?php

namespace App\Models\Transformers;

use App\Models\Feedback;
use Flugg\Responder\Transformers\Transformer;

class FeedbackTransformer extends Transformer
{
    protected $relations = [
        'info' => InfoTransformer::class,
        ];


    public function transform(Feedback $model): array
    {
         return [
             'createdAt'=>$model->created_at,
             'grade'=>$model->grade,
             'comment'=>$model->comment,
         ];
    }

}
