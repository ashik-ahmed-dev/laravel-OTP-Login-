<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use iqbalhasandev\bulksmsbd\Classes\BulkSMSBD;

class AuthOtpController extends Controller
{
    public function index(){
        $title = 'Login With OTP';
        return view('auth.otp_login', compact('title'));
    }

    public function generate(Request $request){

        // Validation phone number
        $request->validate([
            'phone_number' => ['required', 'exists:users,phone_number']
        ]);

        // Otp Generate
        $verificationCode = $this->generate_otp($request->phone_number);
        $message = "Your OTP To Login is - ".$verificationCode->otp;

        return redirect()->route('otp.verification', ['user_id' => $verificationCode->user_id])->with('success',  $message);
    }

    public function generate_otp($phone_number){

        // Get User Data
        $user = User::where('phone_number', $phone_number)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        if($verificationCode && Carbon::now()->isBefore($verificationCode->expired_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expired_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    public function verification($user_id){
        return view('auth.otp_verification')->with([
            'user_id' => $user_id
        ]);
    }

    public function loginWithOtp(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();


        if (!$verificationCode) {
            return redirect()->back()->with('error', 'Your OTP is not correct');
        }elseif($verificationCode && Carbon::now()->isAfter($verificationCode->expired_at)){
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Login Successfully!');
        }
        return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
    }

}
