<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Log;
use Illuminate\Support\Facades\Validator;
use App\Helper\JwtToken;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;


class UserController extends Controller
{
    function UserRegistration(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $password = $request->input('password');

            $rules = [
                'name'=>['required'],
                'email'=>['required','email','unique:users,email'],
                'mobile'=>['required'],
                'password'=>['required']
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'status'=>'fail',
                    'errors'=>$validator->errors()
                ],400);
            }else{
                $user=User::create([
                    'name'=>$name,
                    'email'=>$email,
                    'mobile'=>$mobile,
                    'password'=>$password
                ]);

                return response()->json([
                    'status'=>'succes',
                    'message'=>'User registered succesfully'
                ],200);
            }
    }

    function UserLogin(Request $request){
         $email = $request->input('email');
         $password = $request->input('password');

         $count = User::where('email','=',$email)
               ->where('password','=',$password)
               ->select('id')->first();
         if($count!==null){
              $token=JwtToken::CreateToken($email,$count->id,60*60*24*30);
              return response()->json([
                    'status'=>'succes',
                    'message'=>'User login succesful',
                    'token'=>$token
                ],200)->cookie('token',$token,60*60*24*30);
         }else{
             return response()->json([
                    'status'=>'fail',
                    'message'=>'User Login fail'
                ],400);
         }
    }

    function SentOtp(Request $request){
        $email = $request->input('email');
        $otp = rand(1000,9999);
        try{
            // sessionStorage->set('token',$token);
            $count = User::where('email','=',$email)->count();
            if($count===1){
                 Mail::to($email)->send(new Email($otp));
                 User::where('email','=',$email)->update([
                    'otp'=>$otp
                ]);
                return response()->json([
                        'status'=>'succes',
                        'message'=>'Otp sent succesfully'
                ],200);
            }

        }catch(Exception $e){
            return response()->json([
                    'status'=>'fail',
                    'message'=>'Otp sent fail'
            ],400);
        }

    }

    function VerifyOtp(Request $request){
        $otp = $request->input('otp');
        $email = $request->input('email');
        $count = User::where('otp','=',$otp)
                 ->where('email','=',$email)->first();
        if($count!==null){
           $token = JwtToken::CreateToken($email,$id=null,60*10);
           return response()->json([
                'status'=>'succes',
                'message'=>'Token verifed',
                'token'=>$token
            ],200)->cookie('token',$token,60*7);
        }

    }

    function ResetPassword(Request $request){
        try{
            $password = $request->input('password');
            $email = $request->header('userEmail');
            User::where('email','=',$email)
                    ->update(['password'=>$password]);
            return response()->json([
                    'status'=>'succes',
                    'message'=>'password changed'
            ],200);
        }catch(Exception $e){
            return response()->json([
                    'status'=>'fail',
                    'message'=>'password changed operation fail'
            ],400);
        }

    }

    function GetUser(Request $request){
        $userEmail = $request->header('userEmail');
        $userData = User::where('email','=',$userEmail)->first();
        return response()->json([
                    'status'=>'succes',
                    'message'=>'Request succes',
                    'userData'=>$userData
            ],200);
    }

    function UpdateProfile(Request $request){
        $userEmail = $request->header('userEmail');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $rules = [
                'name'=>['required'],
                'mobile'=>['required'],
                'password'=>['required']
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response()->json([
                    'status'=>'fail',
                    'errors'=>$validator->errors()
                ],400);
            }else{
                $user=User::where('email','=',$userEmail)->update([
                    'name'=>$name,
                    'mobile'=>$mobile
                ]);

                return response()->json([
                    'status'=>'succes',
                    'message'=>'User updated succesfully'
                ],200);
    }

    }

    function RegistrationPage(){
        return Inertia::render('RegistrationPage');
    }

    function LoginPage(){
        return Inertia::render('LoginPage');
    }

    function SendOtpPage(){
        return Inertia::render('SendOtpPage');
    }

    function VerifyOtpPage(){
        return Inertia::render('VerifyOtpPage');
    }

    function ResetPasswordPage(){
        return Inertia::render('ResetPasswordPage');
    }

    function Logout(){
        return Inertia::render('HomePage');
    }

    function ProfilePage(){
        return Inertia::render('ProfilePage');
    }

}
