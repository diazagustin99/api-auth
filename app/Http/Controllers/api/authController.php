<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use  Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class authController extends Controller
{
    public function register(Request $request){
               //validacion de los datos
            $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ]);
            //alta del usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            //respuesta
        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        $credenciales = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credenciales)) {
           $user = Auth::user();
           $token = $user->createToken('token')->plainTextToken;
           $cookie= cookie('cookie_token', $token, 60*24);
           return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
        }else{
            return response(["message"=>"Credenciales no validas"],Response::HTTP_UNAUTHORIZED);
        }
    }

    public function userProfile(Request $request){
        return  response()->json([
            "message" => "userProfile OK",
            "userData" => auth()->user()
        ], Response::HTTP_OK);
    }
    public function loguot(){
        $cookie = Cookie::forget('cookie_token');
        return response()->json(["message"=>"Cierre de sesion OK"], Response::HTTP_OK)->withCookie($cookie);
    }

    public function allUsers(){
        $users = User::all();
        return response()->json([
            "users" => $users
        ]);
    }

}
