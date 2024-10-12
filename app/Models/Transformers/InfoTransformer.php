<?php

namespace App\Models\Transformers;

use Flugg\Responder\Transformers\Transformer;;

class InfoTransformer extends Transformer
{
    protected $relations = [
        'image' => ImageTransformer::class,
        'feedbacks' => FeedbackTransformer::class,
//        'last3feedbacks' => FeedbackTransformer::class,
        ];

    public function transform($model): array
    {
        return [
            'id' => $model->id,
            'firstName' => $model->first_name,
            'lastName' => $model->last_name,
            'birthday' => $model->birthday,
            'is_active' => $model->is_active,
            'averageGrade' => $model->averageGrade,
            'last3feedbacks' => $model->feedbacks->take(3),
        ] ;
    }
}

