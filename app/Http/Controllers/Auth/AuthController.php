<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use App\Models\User;
use App\Models\Role;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    
    public function index()
    {
        if (Auth::user()) {
            return redirect('dashboard');
        }
        return view('auth.login');
    }

    public function registration()
    {
        if (Auth::user()) {
            return redirect('dashboard');
        }
        $role = Role::all();
        return view('auth.register', compact('role'));
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user  = new User();
        $user->name = $data['name'];
        $user->lastname = $data['lname'];
        $user->role_id = $data['role'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        Session::put('user_session', $data['email']);

        return redirect()->intended('dashboard')
                         ->with(
                                 ['success'=> 'You have Successfully loggedin',
                                  'customErr'=> 'Please Login Now'
                                 ]);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $remember_me = $request->has('remember_me') ? true : false;

        if ($remember_me === false) {
            setcookie('login_email', '');
            setcookie('login_pass', '');
        } else {
            setcookie('login_email', $request->email, time() + 60 * 60 * 24);
            setcookie('login_pass', $request->password, time() + 60 * 60 * 24);
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember_me)) {
            return redirect()->intended('dashboard')->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }
 
    public function logout()
    {
        Session::flush();
        Session::forget('user_session');
        Auth::logout();
        return Redirect('login');
    }

}
