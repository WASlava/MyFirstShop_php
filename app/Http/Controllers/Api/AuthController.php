<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\InfoCreateRequest;
use App\Models\Feedback;
use App\Models\Info;
use App\Models\Transformers\FeedbackTransformer;
use App\Models\Transformers\InfoTransformer;
use App\Models\User;
use Flugg\Responder\Responder;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    private Responder $responder;

    public function __construct(Responder $responder) {
        $this->responder = $responder;
    }
    public function profile(): JsonResponse
    {
        $user = Auth::User();
        return $this->responder->success($user)->respond();
    }

    public function login(LoginRequest $request) {

        $request->validate([
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::exists('users', 'email')
            ],
            'password' => ['required'],
        ]);
        /**
         * @var $user User
         */
        $user = User::query()->where('email', '=', $request->email)->first();
        if (!Hash::check($request->password, $user->getAuthPassword())) {
            return $this->responder->error(400, 'Invalid password')->respond(400);
        }

        return $this->responder->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ])->respond();
    }
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        return $this->responder->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ])->respond();
    }

    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        //Auth::user()->currentAccessToken()->delete();
        return $this->responder->success()->respond();
    }

}
