<?php
namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Log;


class JwtToken{
    public static function CreateToken($userEmail,$id=null,$exp=null){

    $key = env('OTP_KEY');
    $payload = [
        'iss' => 'Inertia-pos',
        'iat' => time(),
        'exp' => time()+$exp,
        'userEmail'=>$userEmail,
        'id'=>$id
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
    }

    public static function VerifyToken($token){
        try{
            $key = env('OTP_KEY');
            return $decoded = JWT::decode($token, new Key($key, 'HS256'));
        }catch(Exception $e){
            Log::info($e->getMessage());
            return 'unauthorize';
        }

    }

}




