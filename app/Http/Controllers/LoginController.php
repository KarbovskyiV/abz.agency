<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = Employee::query()->where('email', $request->input('email'))->first();

        $email = $request->input('email');
        $password = $request->input('password');

        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
        ], [
            'email' => ['required', 'exists:employees', 'email'],
            'password' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->messages());
        }

        if ($user && $user->password === $password) {
            Auth::login($user);
            return redirect('/employees');
        }

        return back()->withErrors(['email' => 'Invalid email or password']);
    }
}
