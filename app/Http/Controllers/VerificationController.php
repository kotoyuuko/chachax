<?php

namespace App\Http\Controllers;

use Cache;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\VerificationNotification;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('verification.notice');
    }

    public function success()
    {
        return view('verification.success');
    }

    public function send(Request $request)
    {
        $user = $request->user();
        
        if ($user->verified_at != null) {
            throw new Exception('你已经验证过邮箱了');
        }
        
        $user->notify(new VerificationNotification());

        $request->session()->flash('success', '验证邮件已成功发送。');

        return redirect()->route('verification.notice');
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        
        if (!$email || !$token) {
            throw new Exception('验证链接不正确');
        }
        
        if ($token != Cache::get('verification_' . $email)) {
            throw new Exception('验证链接不正确或已过期');
        }

        if (!$user = User::where('email', $email)->first()) {
            throw new Exception('用户不存在');
        }
        
        Cache::forget('verification_' . $email);
        $user->update([
            'verified_at' => Carbon::now()
        ]);

        return view('verification.success');
    }
}
