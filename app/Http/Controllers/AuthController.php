<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if(auth("web")->attempt($data)) {
            return redirect(route("home"));
        }

        return redirect(route("login"))->withErrors(["email" => "Пользователь не найден, либо данные введены не правильно"]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => ["required", "string", "min:1","max:32"],
            "email" => ["required", "email", "string", "unique:users,email", "min:8","max:32"],
            "password" => ["required", "confirmed","min:8","max:32"]
        ]);

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => bcrypt($data["password"])
        ]);

        if($user) {
            auth("web")->login($user);
        }

        return redirect(route("home"));
    }

    public function logout()
    {
        auth("web")->logout();

        return redirect(route("home"));
    }

    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }
}
