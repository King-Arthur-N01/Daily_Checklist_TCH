<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function indexlogin() {
        return view('auth.login');
    }
    public function authenticateuser(Request $request)
{
    $request->validate([
        'nik' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('nik', 'password');
    $user = User::where('nik', $credentials['nik'])->first();

    if (!$user) {
        return redirect("login")->with('error', 'Login details are not valid');
    }
    if ($user->status == false) {
        return redirect("login")->with('error', 'Your account is not active! Please contact the administrator.');
    }
    if (Auth::attempt($credentials)) {
        return redirect()->intended('home')->with('success', 'Signed in');
    }
    return redirect("login")->with('error', 'Login details are not valid');
}
    public function successlogin(){
        if (Auth::check()) {
            return view('home');
        }
    return redirect("login")->with('You are not allowed to access');
    }
    public function signout(){
        Session::flush();
        Auth::logout();
    return redirect("login");
    }
    public function blockuser() {
        return view('dashboard.view_blacklist.internetpositive2');
    }
}
