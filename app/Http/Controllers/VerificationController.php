<?php

namespace App\Http\Controllers;

use Cache;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\VerificationNotification;
use App\Exceptions\InvalidRequestException;

class VerificationController extends Controller
{
    public function notice(Request $request)
    {
        $user = $request->user();
        
        if ($user->verified_at != null) {
            throw new InvalidRequestException('你已经验证过邮箱了，无需重复验证。');
        }

        return view('verification.notice');
    }

    public function send(Request $request)
    {
        $user = $request->user();
        
        if ($user->verified_at != null) {
            throw new InvalidRequestException('你已经验证过邮箱了，无需重复验证。');
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
            throw new InvalidRequestException('验证链接不正确');
        }
        
        if ($token != Cache::get('verification_' . $email)) {
            throw new InvalidRequestException('验证链接不正确或已过期');
        }

        if (!$user = User::where('email', $email)->first()) {
            throw new InvalidRequestException('用户不存在');
        }

        if ($user->id != $request->user()->id) {
            throw new InvalidRequestException('需验证用户与登录用户不匹配');
        }
        
        Cache::forget('verification_' . $email);
        $user->update([
            'verified_at' => Carbon::now()
        ]);

        return view('verification.success');
    }
}
