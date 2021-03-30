<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!$user || !\Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'password invalid'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json([
            'message' => 'password valid',
            'user' => $user,
            'token' => $token
        ], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'max:24'],
            'confirm_password' => ['required', 'same:password']
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $request->all();
        $user['password'] = bcrypt($user['password']);
        $result = User::create($user);
        $success['token'] = $result->createToken('nApp')->accessToken;
        $success['name'] = $result->name;

        return response()->json(['success' => $success, 'result' => $result],
         Response::HTTP_OK);
    }
}
