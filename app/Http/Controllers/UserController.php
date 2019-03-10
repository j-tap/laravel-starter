<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\ImagesController;

class UserController extends Controller
{
	
	/* Show user info */
	public function show (Request $request)
	{
		return $request->user();
	}

	/* Update user info */
	public function updateProfile (Request $request)
	{
		$rules = [
			'name'  => 'required',
			'email' => 'required|email',
		];

		$this->validate($request, $rules);

		$user = $request->user();
		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->save();
		
		// If exist file
		if ($request->hasFile('file')) {
			$this->validate($request, [
				'file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			]);

			$request->replace([
				'file' => $request->file,
				'user_id' => $user->id,
				'type' => 'ava',
			]);
			
			// Send file to action
			$image = new ImagesController();
			$resultFileUpload = $image->upload($request);
		}

		return response()->json(compact('user'));
	}

	/* Update user password */
	public function updatePassword(Request $request)
	{
		$rules = [
			'new_password'         => 'required',
			'confirm_new_password' => 'required|same:new_password'
		];

		$this->validate($request, $rules);

		$user = $request->user();
		$user->password = bcrypt($request->input('new_password'));
		$user->saveOrFail();

		return response()->json(compact('user'));
	}

	/* Remember password */ // NEED TESTING!!!!
	public function recover (Request $request)
	{
		$user = User::where('email', $request->email)->first();

		if (!$user) {
			$error_message = "Your email address was not found.";
			return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
		}

		try {
			Password::sendResetLink($request->only('email'), function (Message $message) {
				$message->subject('Your Password Reset Link');
			});

		} catch (\Exception $e) {
			// Return with error
			$error_message = $e->getMessage();
			return response()->json([
				'success' => false, 
				'error' => $error_message
			], 401);
		}

		return response()->json([
			'success' => true, 
			'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
		]);
	}

	public function getAll (Request $request) 
	{
		return response()->json([
			'success' => true, 
			'users'=> User::where('id', '!=', auth()->id())->get()//User::all()
		]);
	}
	
	public function getById (Request $request) 
	{
		$id = $request->id;

		return response()->json([
			'success' => true, 
			'user'=> User::find($id)
		]);
	}
}