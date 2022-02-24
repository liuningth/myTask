<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    /**
     * login
     * @param UserRequest $request
     * @return string
     */
    public function login(UserRequest $request): string
    {
        $admin = $this->userRepository->findOne();

        return view('admin.login.index', compact('admin'));
    }
}
