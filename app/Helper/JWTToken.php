<?php

namespace App\Helper;

use Firebase\JWT\JWT;

class JWTToken{

   
   public static function CreateToken($userEmail, $userId){

    $key = env('JWT_KEY');
     
        $payload = [
            'iss' => 'laravel-token',
            'iat' => time(),
            'exp' => time() + 60 * 24 * 30,//30 days
            'userEmail' => $userEmail,
            'userId' => $userId,
        ];

     return JWT::encode($payload, $key, 'HS256');


    }
}

 ?>
