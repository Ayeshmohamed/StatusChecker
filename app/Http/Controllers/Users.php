<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

interface Users{
	public function register(Request $request);
	public function login (Request $request);
}


  ?>