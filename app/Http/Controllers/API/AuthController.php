<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => config('constantapiresponse.fail_status'),
                'message' => __('Login validation error'),
                'data' => $validation->errors(),
            ], config('constantapiresponse.fail_status_code'))->throwResponse();
        }

        try {
            $credentials = $request->only('email', 'password');

            if (!$token = Auth::guard('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            Log::error('--------something went wrong with login api ----------', [
                'Message' => $th->getMessage(),
                'Line' => $th->getLine(),
                'File' => $th->getFile(),
                'code' => $th->getCode(),
            ]);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 60
            // auth()->factory()->getTTL() * 60
        ]);
    }
}
