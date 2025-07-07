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

             ],200)->cookie('token',$token,60*24*30);
         }
         else{

             return response()->json([

                 'status'=>'fail',
                  'message'=> 'Unauthorized'

            ],401);
         }
    }

    public function DashboardPage(Request $request){

       $user = $request->header('email');

        return response()->json([

             'status'=>'success',
             'message'=>'User login successfully',
             'user'=>$user
        ],200);

    }

    public function Logout(){

         return response()->json([
            'status'=>'Success',
             'message'=>'Logout',

         ],200)->cookie('token','',-1);
     }
}
