<?php

namespace App\Http\Controllers;

use App\Models\PaymentLog;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Exceptions\InvalidRequestException;

class UsersController extends Controller
{
    public function profile(Request $request)
    {
        return view('users.profile')
            ->with('user', $request->user());
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;
        if ($user->email != $request->email) {
            $user->email = $request->email;
            $user->verified_at = null;
        }
        $user->save();

        $request->session()->flash('success', '个人资料更新成功');

        return redirect()->route('user.profile');
    }

    public function recharge(Request $request)
    {
        $user = $request->user();

        $logs = PaymentLog::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(15);

        return view('users.recharge')
            ->with('user', $user)
            ->with('logs', $logs);
    }
}
