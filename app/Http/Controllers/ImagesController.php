<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Images;

class ImagesController extends Controller
{
    public function upload (Request $request)
    {

		if (is_array($request->file) 
		&& is_numeric($request->user_id) 
		&& is_string($request->type)) {

			$file = $request->file;
			$userId = $request->user_id;
			$type = $request->type;

			$imageName = str_random(20) . '.' . $file->getClientOriginalExtension();
			$uploadPath = 'uploads/' . $userId . '/'. $type;
			// Save file on server
			$successUpload = $file->move($uploadPath, $imageName);

			$images = new Images();
			$images->user_id = $userId;
			$images->name = $imageName;
			$images->type = $type;
			// Save file on DB
			$successSave = $images->save();

			return ($successUpload && $successSave);

		} else {

			return false;
		}


		// Images::make($request)->resize(400, 400)->save(public_path('uploads/') . $fileName);


		// Image::configure(array('driver' => 'imagick'));
		// $image = Image::make('public/foo.jpg')->resize(300, 200);


        // $path = public_path() . '\uploads\\';
		// $file = $request->file('image');

		// foreach ($file as $f) {
		// 	$filename = str_random(20) .'.' . $f->getClientOriginalExtension() ?: 'png';
		// 	$img = ImageInt::make($f);
		// 	$img->resize(200,200)->save($path . $filename);
		// 	Images::create(['user_id' => $request->user_id, 'img' => $filename]);
		// }

		// return redirect()->route('images.index');
    }
}
