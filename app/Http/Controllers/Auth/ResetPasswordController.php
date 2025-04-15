<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Model\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Hash;
use DB;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected function credentials(Request $request)
    {
        $request->merge([
            'email' => base64_encode($request->email),
        ]);
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    public function reset(Request $request)
    {
        $input = $request->all();
        $user = User::where('email', base64_encode($input['email']))->first();
        if ($user) {
            $password = Hash::make($input['password']);
            $user->password = $password;
            $user->save();

            DB::table('password_resets')->where(['email' => $user->email])->delete();
            request()->session()->flash('status', __('messages.PASSWORD_CHANGED_SUCCESSFULLY'));
            return redirect('login');
        } else {
            return redirect('login');
        }
    }

}
