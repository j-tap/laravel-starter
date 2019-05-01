<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Config;
use App\Image;

class ImagesController extends Controller
{
    public function upload (Request $request)
    {
		if (is_object($request->file) 
		&& is_numeric($request->user_id) 
		&& is_string($request->type)) {
			
			$file = $request->file;
			$userId = $request->user_id;
			$type = $request->type;

			$folder= Config::get('image.folder');
			$image = new Image();

			switch ($request->type) {
				case 'ava':
					$uploads = new Filesystem;
					$uploads->cleanDirectory($folder);
					$image->where('type', 'ava')->delete();
					break;
			}

			$imageName = str_random(20) . '.' . $file->getClientOriginalExtension();
			$uploadPath = $folder . '/' . $userId . '/'. $type;
			// Save file on server
			$successUpload = $file->move($uploadPath, $imageName);

			$image->user_id = $userId;
			$image->name = $imageName;
			$image->type = $type;
			// Save file on DB
			$successSave = $image->save();

			if ($successUpload && $successSave) {
				return true;
			}
		}

		return false;
    }

	public function get (Request $request)
    {
		if (is_numeric($request->user_id) 
		&& is_string($request->type)) {
			$where = [
				'user_id' => $request->user_id,
				'type' => $request->type,
			];
			switch ($request->type) {
				case 'ava':
					return Image::where($where)->firstOrFail();
			}
			return Image::where($where)->get();
		}
		return false;
	}
}
