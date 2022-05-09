<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Register\StoreRequest;
use App\Repositories\User\UserRepositoryInterface;

class RegisterController extends Controller
{
    protected $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo
    ) {
        $this->middleware('guest');
        $this->userRepo = $userRepo;
    }

    public function register(StoreRequest $request)
    {
        try {
            $result = $this->userRepo->insert([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'role_id' => config('auth.roles.user'),
            ]);
            if ($result) {
                return response()->json([
                    'message' => __('messages.register-success'),
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
