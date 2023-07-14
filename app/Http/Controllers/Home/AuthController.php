<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ActiveSms;
use App\Models\Setting;
use App\Models\User;
use App\Traits\SendEmailTrait;
use App\Traits\SendSmsTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AuthController extends Controller
{
    use SendSmsTrait;
    use SendEmailTrait;
    public function loginPage(){
        if (Auth::check())
            return redirect('/profile');

        return Inertia::render('Home/Auth/AuthIndex');
    }
    public function checkEmail(Request $request){
        $request->validate([
            'email' => 'required|min:10',
        ]);
        DB::table('active_sms')->where('expire' , '<=', Carbon::now()->timestamp)->delete();

        if ($request->show == 1){
            $user = User::where('email' , $request->email)->first();
            if($user){
                return 2;
            }else{
                $code = ActiveSms::buildCode();
                ActiveSms::create([
                    'code'=> $code,
                    'expire'=> Carbon::now()->addSecond(120)->timestamp,
                    'phone'=>$request->email
                ]);
                $message = "کد تایید شما برای ورود به وبسایت : $code";
                $this->sendEmail($request->email , $message);
                return 3;
            }
        }
        if ($request->show == 2){
            $code = ActiveSms::buildCode();
            ActiveSms::create([
                'code'=> $code,
                'expire'=> Carbon::now()->addSecond(120)->timestamp,
                'phone'=>$request->email
            ]);
            $message = "کد تایید شما برای ورود به وبسایت : $code";
            $this->sendEmail($request->email , $message);
            return 3;
        }
    }
    public function check(Request $request){
        $request->validate([
            'number' => 'required|min:17|max:17',
        ]);
        DB::table('active_sms')->where('expire' , '<=', Carbon::now()->timestamp)->delete();
        $num1 = explode('-',$request->number);
        $num2 = implode('',$num1);
        $num3 = explode(' ',$num2);
        $num4 = implode('',$num3);
        if ($request->show == 1){
            $user = User::where('number' , $num4)->first();
            if($user){
                return 2;
            }else{
                $code = ActiveSms::buildCode();
                ActiveSms::create([
                    'code'=> $code,
                    'expire'=> Carbon::now()->addSecond(120)->timestamp,
                    'phone'=>$request->number
                ]);
                $this->sendSms("$num4" , $code,env('GHASEDAKAPI_Number'));
                return 3;
            }
        }
        if ($request->show == 2){
            $code = ActiveSms::buildCode();
            ActiveSms::create([
                'code'=> $code,
                'expire'=> Carbon::now()->addSecond(120)->timestamp,
                'phone'=>$request->number
            ]);
            $this->sendSms("$num4" , $code,env('GHASEDAKAPI_Number'));
            return 3;
        }
    }
    public function checkCode(Request $request){
        $request->validate([
            'phone' => ['required','min:17','max:17' , Rule::exists('active_sms')],
            'code' => ['required','min:6','max:6' , Rule::exists('active_sms')],
        ]);
        $check = ActiveSms::where('code',$request->code)->where('expire' , '>='  ,Carbon::now()->timestamp)->where('phone',$request->phone)->first();
        if ($check){
            if ($request->show == 1){
                return ['success',5];
            }
            if ($request->show == 2){
                return ['success',6];
            }
        }else{
            return ['fail',''];
        }
    }
    public function checkEmailCode(Request $request){
        $request->validate([
            'email' => 'required|min:10',
            'code' => ['required','min:6','max:6' , Rule::exists('active_sms')],
        ]);
        $check = ActiveSms::where('code',$request->code)->where('expire' , '>='  ,Carbon::now()->timestamp)->where('phone',$request->email)->first();
        if ($check){
            if ($request->show == 1){
                return ['success',5];
            }
            if ($request->show == 2){
                return ['success',6];
            }
        }else{
            return ['fail',''];
        }
    }
    public function changePassword(Request $request){
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $num1 = explode('-',$request->phone);
        $num2 = implode('',$num1);
        $num3 = explode(' ',$num2);
        $num4 = implode('',$num3);
        $user = User::where('number',$num4)->first();
        $user->update([
            'password'=> Hash::make($request->password)
        ]);
        Auth::login($user);
        return ['success' , $user];
    }
    public function changeEmailPassword(Request $request){
        $request->validate([
            'password' => 'required|min:6',
        ]);
        $user = User::where('email',$request->email)->first();
        $user->update([
            'password'=> Hash::make($request->password)
        ]);
        Auth::login($user);
        return ['success' , $user];
    }
    public function makeUser(Request $request){
        $request->validate([
            'phone' => ['required','min:17','max:17' , Rule::exists('active_sms')],
            'password' => 'required|min:8',
            'name' => 'unique:users,name'
        ]);
        $num1 = explode('-',$request->phone);
        $num2 = implode('',$num1);
        $num3 = explode(' ',$num2);
        $num4 = implode('',$num3);
        $role = Setting::where('key' , 'role')->pluck('value')->first();
        $user = User::create([
            'name'=> $request->name,
            'number'=> $num4,
            'password'=> Hash::make($request->password)
        ]);
        if ($role){
            $user->syncRoles($role);
        }
        Auth::login($user);
        return ['success' , $user];
    }
    public function makeUserEmail(Request $request){
        $request->validate([
            'email' => 'required|min:10',
            'password' => 'required|min:8',
            'name' => 'unique:users,name'
        ]);
        $role = Setting::where('key' , 'role')->pluck('value')->first();
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        if ($role){
            $user->syncRoles($role);
        }
        Auth::login($user);
        return ['success' , $user];
    }
    public function login(Request $request){
        $request->validate([
            'number' => ['required','min:17','max:17'],
            'password' => 'required|min:8',
        ]);
        $num1 = explode('-',$request->number);
        $num2 = implode('',$num1);
        $num3 = explode(' ',$num2);
        $num4 = implode('',$num3);
        $user = User::where('number' , $num4)->first();
        $credentials = [
            'number' => $num4,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return ['success',$user];
        } else {
            return ['no', 0];
        }
    }
    public function loginEmail(Request $request){
        $request->validate([
            'email' => ['required','min:10'],
            'password' => 'required|min:8',
        ]);
        $user = User::where('email' , $request->email)->first();
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            return ['success',$user];
        } else {
            return ['no', 0];
        }
    }
    public function logout(){
        Auth::logout();
        return 0;
    }
}
