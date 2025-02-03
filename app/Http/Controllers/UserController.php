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
        try{
            $name = $request->input('name');
            $email = $request->input('email');
            $mobile = $request->input('mobile');
            $password = $request->input('password');
            $user=User::create([
                    'name'=>$name,
                    'email'=>$email,
                    'mobile'=>$mobile,
                    'password'=>$password
                ]);
            $data=['message'=>'User Registration succesful','status'=>true,'error'=>''];
            return redirect()->route('RegistrationPage')->with($data);
        }catch(Exception $e){
            $data=['message'=>'User Registration fail','status'=>false,'error'=>''];
        }

            // $rules = [
            //     'name'=>['required'],
            //     'email'=>['required','email','unique:users,email'],
            //     'mobile'=>['required'],
            //     'password'=>['required']
            // ];
            // $validator = Validator::make($request->all(),$rules);
            // if($validator->fails()){
            //     return response()->json([
            //         'status'=>'fail',
            //         'errors'=>$validator->errors()
            //     ],400);
            // }else{
            //     $user=User::create([
            //         'name'=>$name,
            //         'email'=>$email,
            //         'mobile'=>$mobile,
            //         'password'=>$password
            //     ]);

            //     return response()->json([
            //         'status'=>'succes',
            //         'message'=>'User registered succesfully'
            //     ],200);
            // }
    }

    function UserLogin(Request $request){
        try{
           $email = $request->input('email');
            $password = $request->input('password');

            $count = User::where('email','=',$email)
                ->where('password','=',$password)
                ->select('id')->first();
            if($count!==null){
              $request->session()->put('email',$email);
              $request->session()->put('user_id',$count->id);
              $data=['message'=>'User Login succesful','status'=>true,'error'=>''];
              return redirect()->route('LoginPage')->with($data);
            }else{
              $data=['message'=>'User Login fail','status'=>false];
              return redirect()->route('LoginPage')->with($data);
            }
        }catch(Exception $e){
            $data=['message'=>'User Login fail','status'=>false,'error'=>$e->getMessage()];
            return redirect()->route('LoginPage')->with($data);
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
                $request->session()->put('email',$email);
                $data=['message'=>'Otp sent succesful','status'=>true,'error'=>''];
                return redirect()->route('SendOtpPage')->with($data);
            }

        }catch(Exception $e){
               $data=['message'=>'Otp sent fail','status'=>false,'error'=>''];
               return redirect()->route('SendOtpPage')->with($data);
        }

    }

    function VerifyOtp(Request $request){
            $otp = $request->input('otp');
            $email = $request->session()->get('email');
            $count = User::where('otp','=',$otp)
                    ->where('email','=',$email)->first();
            if($count!==null){
                $request->session()->put('verify_otp','yes');
                $data=['message'=>'Otp verification succesful','status'=>true,'error'=>''];
                return redirect()->route('SendOtpPage')->with($data);
            }else{
                $data=['message'=>'Otp verification fail','status'=>false,'error'=>''];
                return redirect()->route('SendOtpPage')->with($data);
            }
    }

    function ResetPassword(Request $request){
            $password = $request->input('password');
            $email = $request->session()->get('email');
            $verify_otp=$request->session()->get('verify_otp');
            if($verify_otp==='yes'){
                User::where('email','=',$email)
                    ->update(['password'=>$password]);
                $data=['message'=>'Password changed successfully','status'=>true,'error'=>''];
                return redirect()->route('LoginPage')->with($data);
            }else{
                $data=['message'=>'Password changed successfully','status'=>false,'error'=>''];
                return redirect()->route('SendOtpPage')->with($data);
            }
    }

    function UpdateProfile(Request $request){
        try{
            $email = $request->header('email');
            $name = $request->input('name');
            $mobile = $request->input('mobile');
            $email = $request->input('email');
            $password = $request->input('password');

            $user=User::where('email','=',$email)->update([
                'name'=>$name,
                'mobile'=>$mobile,
                'email'=>$email,
                'password'=>$password
            ]);
            $data=['message'=>'Data changed successfully','status'=>true,'error'=>''];
            return redirect()->route('ProfilePage')->with($data);
        }catch(Exception $e){
            $data=['message'=>'Data changed operation fail','status'=>false,'error'=>''];
            return redirect()->route('ProfilePage')->with($data);
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

    function Logout(Request $request){
        $request->session()->flush();
        return redirect()->route('LoginPage');
    }

    function ProfilePage(Request $request){
        $email = $request->header('email');
        $user_id = $request->header('user_id');
        $userData = User::where('email','=',$email)
                    ->where('id','=',$user_id)->first();
        return Inertia::render('ProfilePage',['list'=>$userData]);
    }

}
