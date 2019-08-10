<?php

namespace App\Http\Controllers\Api;




use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Users;
use App\Http\Controllers\Controller;

class UsersController extends Controller implements  Users
{
	/*
	@prams
	login After signUp parameter to alow login after registere  
	*/
	public $loginAfterSignUp = true;
    

    public function register(Request $request)
    {
    	
        $validator=$this->validator($request->all());

        if ($validator->fails()) {

            return $validator->errors()->getMessages();

        }else{

        	$user = new User();
	        $user->username = $request->username;
	        $user->email = $request->email;
	        $user->phone = $request->phone;
	        $user->password = bcrypt($request->password);
	        $user->save();
	 
	        if ($this->loginAfterSignUp) {
	            return $this->login($request);
	        }
	 
	        return response()->json([
	            'success' => true,
	            'data' => $user
	        ], 200);

        }

        
    }


    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }
 
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }

     public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
    public function validator($data){
        $validator = Validator::make($data, [
            'username' => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:10',
            'phone'    => 'required|numeric|digits_between:11,15'
        ]);
        return $validator;
    }
}
