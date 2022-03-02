<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $genders = Gender::all();

        if (empty($user)) {
            return redirect()
                ->route('home')
                ->with('message', __('messages.result'));
        }

        return view('user.profile.edit', [
            'user' => $user,
            'genders' => $genders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        if ($request->avatar != null) {
            $newAvatarName = time() . '-' . str_replace(' ', '-', $request->name) . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('avatars'), $newAvatarName);
        } else {
            $newAvatarName = User::find($id)->avatar;
        }

        $user = User::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'birthday' => $request->input('birthday'),
                'gender_id' => $request->input('gender'),
                'phone' => $request->input('phone'),
                'avatar' => $newAvatarName,
        ]);

        return redirect()
            ->route('profile.edit', $id)
            ->with('message', __('messages.update'));
    }
}
