<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * login
     * @param UserRequest $request
     * @return string
     */
    public function login(UserRequest $request): string
    {
        //$admin = DB::table('admin_user')->where('name', $name)->first(['pass', 'id']);
        $admin = app(UserRepository::class)
            ->where('name', $request->post('name'))
            ->first(['pass', 'id']);

        return view('admin.login.index', compact('admin'));
    }
}
