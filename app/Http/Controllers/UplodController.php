<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UplodController extends Controller
{
    /**
     * upload picture
     * @param Request $request
     * @return string
     */
    public function uplodImage(Request $request): string
    {
        $path = '/upload/';
        $filePath = $request->image->store('images', 'uplod');

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
