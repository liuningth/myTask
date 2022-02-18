<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * login
     * @param Request $request
     * @return string
     */
    public function login(Request $request): string
    {
        $name = $request->post('name');
        $pass = $request->post('pass');
        $admin = DB::table('admin_user')->where('name', $name)->first(['pass', 'id']);
        if (empty($admin)) {
            return $this->json([
                'code' => 400,
                'msg' => 'user is not exists',
                'data' => []
            ]);
        }
        if ($admin->pass != md5($pass)) {
            return $this->json([
                'code' => 400,
                'msg' => 'pass is wrong',
                'data' => []
            ]);
        }
        return $this->json([
            'code' => 200,
            'msg' => 'login success',
            'data' => [
                'id' => $admin->id
            ]
        ]);
    }
}
