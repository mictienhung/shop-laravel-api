<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use JWTAuth;
use JWTAuthException;
use Validator;

use App\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'msg' => 'invalid email or password',
                ], 401);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'msg' => 'failed to create token',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
            ],
        ]);
    }

    public function register(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:255',
            'role' => 'required|in:' . User::ROLE_NORMAL . ',' . User::ROLE_SELLER,
        ]);

    	if ($validator->passes()) {
    		$user = new User;
    		$user->name = $request->get('name');
    		$user->email = $request->get('email');
    		$user->password = bcrypt($request->get('password'));
    		$user->role = $request->get('role');
    		if ($user->save()) {
    			return response()->json([
    				'success' => true,
    				'data' => $user
    			]);
    		}
    	} else {
    		return response()->json([
    			'msg' => $validator->errors()->first()
    		], 401);
    	}
    }

    public function getAuthUser(Request $request)
    {
    	$user = JWTAuth::parseToken()->authenticate();
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function changePassword(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'newPassword' => 'required|min:6|max:255'
        ]);

    	if ($validator->passes()) {
    		$user = JWTAuth::parseToken()->authenticate();
    		$user->password = bcrypt($request->get('newPassword'));
    		if ($user->save()) {
    			return response()->json([
		            'success' => true
		        ]);
    		} else {
    			return response()->json([
		            'msg' => 'Can\'t update password'
		        ], 400);
    		}
    	} else {
    		return response()->json([
    			'msg' => $validator->errors()->first()
    		], 401);
    	}
    }

    public function forgotPassword(Request $request)
    {

    }
}
