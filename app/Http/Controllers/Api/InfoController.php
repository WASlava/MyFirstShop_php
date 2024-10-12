<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\InfoCreateRequest;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use App\Models\Info;
use App\Models\Transformers\FeedbackTransformer;
use App\Models\Transformers\InfoTransformer;
use Flugg\Responder\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InfoController extends Controller
{
    private Responder $responder;

    public function __construct(Responder $responder) {
        $this->responder = $responder;
    }

    public function index(): JsonResponse
    {
      return $this->responder
            ->success(Info::query()->with('image')->get(), InfoTransformer::class)
            ->with(['image', 'last3feedbacks', 'averageGrade'])
//            ->with(['image', 'feedbacks', 'averageGrade'])
            ->respond();
    }


    public function one(Info $info): JsonResponse
    {
        return $this->responder
            ->success($info, InfoTransformer::class)
            ->with('image')
            ->respond();
    }

    public function update(Info $info, InfoCreateRequest $request): JsonResponse
    {
        $info->update($request->validated());
        return $this->one($info);

    }

//    public function feedback(Feedback $feedback): JsonResponse
//    {
//        return $this->responder
//            ->success($feedback, FeedbackTransformer::class)
//            ->with(['feedback.info'])
//            ->respond();
//    }
//
//    public function addFeedback(FeedbackRequest $request, Info $info): JsonResponse
//    {
//        $feedback = new Feedback($request->validated());
//        $feedback->info_id = $info->id;
//        $feedback->save();
//
//        return $this->responder->success($feedback, FeedbackTransformer::class)->respond();
//    }

//    public function store(Request $request, $infoId)
//    {
//        // Валідація вхідних даних
//        $validatedData = $request->validate([
//            'grade' => 'required|integer|min:1|max:5',
//            'comment' => 'required|string|max:1000',
//        ]);
//
//        // Створення нового відгуку
//        $feedback = new Feedback();
//        $feedback->grade = $validatedData['grade'];
//        $feedback->comment = $validatedData['comment'];
//        $feedback->info_id = $infoId; // Зв'язок з інформацією (припустимо, що у вас є поле info_id)
//
//        if ($feedback->save()) {
//            return response()->json(['success' => true]);
//        } else {
//            return response()->json(['success' => false, 'message' => 'Не вдалося зберегти відгук.']);
//        }
//    }
    public function profile(): JsonResponse
    {
        $user = Auth::user();
        return $this->responder->success($user)->respond();

    }

}
