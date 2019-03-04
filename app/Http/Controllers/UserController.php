<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Validator, DB, Hash, Mail;
use App\Http\Controllers\ImagesController;

class UserController extends Controller
{
	
	/* Show user info */
	public function show (Request $request)
	{
		return $request->user();
	}

	/* Update user info */
	public function updateProfile(Request $request)
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

		$file = $request->only('image');
		$img = $file['image'];
		// Build the input for validation
		$fileArray = array('image' => $img);

		$rules = array(
			'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
		);

		// Now pass the input and rules into the validator
 		$validator = Validator::make($fileArray, $rules);

		// Check to see if validation fails or passes
		if ($validator->fails())
		{
			// Redirect or return json to frontend with a helpful message to inform the user 
			// that the provided file was not an adequate type
			return response()->json(['error' => $validator->errors()->getMessages()], 400);
			
		} else {
			// Store the File Now
			// read image from temporary file
			$fileName = Carbon::now()->timestamp . '_' . uniqid() . '.'
			. explode('/', explode(':', substr($fileArray, 0, strpos($fileArray, ';')))[1])[1];
			Images::make($file)->resize(400, 400)->save(public_path('uploads/') . $fileName);
		};

		//$image = $request->only('id', 'image');
		//var_dump($request);die;
		//ImagesController::store($image);
		// $imageData = $request->get('image');
        // $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' 
		// . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        // Image::make($request->get('image'))->save(public_path('uploads/') . $fileName);

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