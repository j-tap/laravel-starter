<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Validator, DB, Hash, Mail;

class AuthController extends Controller
{
	/* Registration */
	public function register (Request $request)
	{
		$credentials = $request->only('name', 'email', 'password');
		
		$rules = [
			'name' => 'required|min:2|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required'
		];

		$validator = Validator::make($credentials, $rules);
		
		if ($validator->fails()) {
			return response()->json([
				'success'=> false, 
				'error'=> $validator->messages()
			], 422);
		}

		$name = $request->name;
		$email = $request->email;
		$password = $request->password;
		$verification_code = str_random(30);
		$subject = 'Please verify your email address.';
		
		$user = User::create([
			'name' => $name, 
			'email' => $email, 
			'password' => Hash::make($password)
		]);

		DB::table('user_verifications')->insert([
			'user_id' => $user->id,
			'token' => $verification_code
		]);

		$data = array(
			'name'=>$name, 
			'email'=>$email, 
			'subject'=>$subject,
			'verification_code'=>$verification_code,
		);
		/* 
		// ERROR "Malformed UTF-8 characters, possibly incorrectly encoded"
		Mail::send('email.verify', $data, function ($message) use ($name, $email, $subject, $verification_code)
		{
			$message->to($email, $name);
			$message->subject($subject);
		});
		*/
		return response()->json([
			'success'=> true, 
			'message'=> 'Thanks for signing up! Please check your email to complete your registration.' 
			.' Verification code: '. url('verify', $verification_code)
		]);
	}

	/* Verify user */
	public function verify (Request $request)
	{
		$verification_code = $request->code;
		$check = DB::table('user_verifications')->where('token', $verification_code)->first();

		if (!is_null($check)) {
			$user = User::find($check->user_id);

			if ($user->is_verified == 1) {
				return response()->json([
					'success'=> true,
					'message'=> 'Account already verified.'
				]);
			}

			$user->is_verified = 1;
			$user->save();

			DB::table('user_verifications')->where('token', $verification_code)->delete();

			return response()->json([
				'success'=> true,
				'message'=> 'You have successfully verified your email address.'
			]);
		}

		return response()->json([
			'success'=> false, 
			'error'=> 'Verification code is invalid.'
		], 500);
	}

	/* Login */
	public function login (Request $request)
	{
		$credentials = $request->only('email', 'password');
		
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
		];

		$validator = Validator::make($credentials, $rules);

		if ($validator->fails()) {
			return response()->json([
				'success'=> false, 
				'error'=> $validator->messages()
			], 422);
		}
		
		$credentials['is_verified'] = 1;
		
		try {
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json([
					'success' => false, 
					'error' => 'Incorrect username or password'
				], 404);
			}

		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json([
				'success' => false, 
				'error' => 'Failed to login, please try again.'
			], 500);
		}

		// all good so return the token
		return response()->json(compact('token', 'user'));
		// return response()->json([
		// 	'success' => true, 
		// 	'data'=> [ 'token' => $token ]
		// ], 200);
	}

	/* Logout */ // NEED TESTING!!!!
	public function logout (Request $request) 
	{
		$this->validate($request, ['token' => 'required']);
		
		try {
			JWTAuth::invalidate($request->input('token'));
			return response()->json([
				'success' => true, 
				'message'=> 'You have successfully logged out.'
			]);

		} catch (JWTException $e) {
			// something went wrong whilst attempting to encode the token
			return response()->json([
				'success' => false, 
				'error' => 'Failed to logout, please try again.'
			], 500);
		}
	}
}