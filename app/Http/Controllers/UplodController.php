<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UploadRequest;

class uploadController extends Controller
{
    /**
     * upload picture
     * @param UploadRequest $request
     * @return string
     */
    public function uploadImage(UploadRequest $request): string
    {
        $path = '/upload/';
        $filePath = $request->image->store('images', 'upload');

        if ($filePath) {
            $image = $path . $filePath;
            return $this->json([
                'code' => 200,
                'msg' => 'upload success',
                'data' => $image
            ]);
        }
        return $this->json([
            'code' => 400,
            'msg' => 'upload fail',
            'data' => []
        ]);
    }
}
