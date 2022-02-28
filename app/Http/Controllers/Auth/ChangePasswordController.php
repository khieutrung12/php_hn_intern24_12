<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return redirect()
                ->route('home')
                ->with('message', __('messages.result'));
        }

        return view('profile.changepassword', [
            'user' => $user,
        ]);
    }

    public function change(ChangePasswordRequest $request, $id)
    {
        $compare = auth()->attempt([
            'email' => auth()->user()->email,
            'password' => $request->input('current_password'),
        ]);

        if ($compare) {
            if (!Hash::check($request->input('new_password'), auth()->user()->password)) {
                $user = User::where('id', $id)
                    ->update([
                        'password' => Hash::make($request->input('new_password')),
                ]);
                $message = __('messages.update');
            } else {
                $message = __('messages.old-password');
            }
        } else {
            $message = __('messages.password-fail');
        }

        return redirect()
            ->route('password.edit', $id)
            ->with('message', $message);
    }
}
