<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function UserRegistration(Request $request)
    {

        //  dd($request->all());

        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email:unique:users,email',
                'password' => 'required',
            ]);

            $user = User::create([

                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')

            ]);

            return response()->json([

                'status' => 'success',
                'message' => 'User Created Successfully',
                'data' => $user
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status' => 'fail',
                'message' => $e->getMessage(),
                
            ]);
        }
    }

    public function UserLogin  (Request $request){

         $count = User::where('email',$request->input('email'))->where('password',$request->input('password'))->select('id')->first();

         if($count !==null){
             $token = JWTToken::CreateToken($request->input('email'),$count->id);

             return response()->json([

                'status'=>'success',
                'message'=>'Login Created Successfully',
                'token'=>$token

             ],200)->cookie('tolen',$token,60*24*30);
         }
    }
}
