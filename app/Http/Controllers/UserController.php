<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UpdateRequest;

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

    public function viewOrders($id)
    {
        $users = User::findorfail($id);
        $orders = Order::where('user_id', $users->id)->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));

        return view('user.profile.order.orders')->with(compact('orders'));
    }

    public function viewDetailOrder($id)
    {
        $order = Order::findorfail($id);

        return view('user.profile.order.view_order')->with(compact('order'));
    }

    public function viewStatusOrder($idUser, $isSatus)
    {
        $users = User::findorfail($idUser);
        $orders = Order::where([
            ['user_id', $users->id],
            ['order_status_id', $isSatus],
        ])->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));

        return view('user.profile.order.orders')->with(compact('orders'));
    }
}
