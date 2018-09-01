<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthController extends Controller
{
    //
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:4'
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');


        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $code = 200;
        $message = $name.' Ajouté avec succes !';

        if(!$user->save())
        {
            $code = 404;
            $message = ' Erreur a l\'insertion !';
        }


        $response = [
            'Message' => $message
        ];
        return response()->json($response,$code);
    }

    public function signin(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password'); 
        
        try{
            if(! $token = JWTAuth::attempt($credentials))
            {
                return response()->json(['Message' => 'Invalid Credentials'],404);
            }
        }catch(JWTException $ex)
        {
            return response()->json(['Message' => 'Erreur a la creation du Token !'],500);
        }

       return response()->json(['Token' => $token],200);
    
    }
}
