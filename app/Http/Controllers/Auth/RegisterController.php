<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\InviteCode;
use App\Models\InviteLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $inviteCode = InviteCode::findCode($request->code);

        if (config('env.require_invite') && !$inviteCode) {
            throw new InvalidRequestException('系统开启了强制邀请注册，请填写有效的邀请码');
        }

        if (config('env.require_invite') && $inviteCode->usable < 1) {
            throw new InvalidRequestException('邀请码已达到最大使用次数');
        }

        $user = $this->create($request->all());

        if ($inviteCode) {
            $inviteCode->usable -= 1;
            $inviteCode->save();

            $inviteLog = InviteLog::create([
                'user_id' => $user->id,
                'invite_code_id' => $inviteCode->id
            ]);
        }

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
