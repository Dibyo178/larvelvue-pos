<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVierificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');

        $result = JWTToken::VerifyToken($token);

        if ($result == 'Unauthorized') {

            return response()->json([

                'status' => 'failed from verificationmiddleware',
                'message' => 'Unauthorized'
            ]);

        } else{
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userId);
           return $next($request);

        }
    }
}

