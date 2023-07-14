<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Pay;
use Illuminate\Support\Facades\DB;
use App\Models\PayMeta;

class PayController extends Controller
{
    public function index(Request $request){
        DB::table('pays')->where('seen', 0)->update(['seen' => 1]);
        if($request->value){
            DB::table('pay_metas')->whereIn('pay_id', $request->value)->delete();
            DB::table('pays')->whereIn('id', $request->value)->delete();
        }
        $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش پرداختی')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف پرداختی')->pluck('name');
        if(auth()->user()->admin == 1 or count($showSome) >= 1){
            $show = 1;
        }else{
            $show = 0;
        }
        if(auth()->user()->admin == 1 or count($checkDeletes) >= 1){
            $deleted = 1;
        }else{
            $deleted = 0;
        }
        if($request->deliver){
            $payId = Pay::where('id' , $request->deliver['id'])->first();
            $payId->update([
                'deliver' => $request->deliver['deliver']
            ]);
        }
        if($request->sort == 0){
            $sort = Pay::latest()->pluck('id')->toArray();
        }
        if($request->sort == 1){
            $sort = Pay::latest()->where('status' , '!=' , 100)->pluck('id')->toArray();
        }
        if($request->sort == 2){
            $sort = Pay::latest()->where('status' , 100)->pluck('id')->toArray();
        }
        if($request->sortDeliver == 0){
            $sortDeliver = Pay::latest()->pluck('id')->toArray();
        }
        if($request->sortDeliver == 1){
            $sortDeliver = Pay::latest()->where('deliver' , 0)->pluck('id')->toArray();
        }
        if($request->sortDeliver == 2){
            $sortDeliver = Pay::latest()->where('deliver' , 1)->pluck('id')->toArray();
        }
        if($request->date){
            $date = Pay::latest()->whereDate('created_at',$request->date)->pluck('id')->toArray();
        }else{
            $date = Pay::latest()->pluck('id')->toArray();
        }
        if($request->search){
            $search = Pay::latest()->where("property" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
            if (count($search) == 0){
                $search = Pay::latest()->where("refId" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
            }
        }else{
            $search = Pay::latest()->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($sort, $sortDeliver,$date,$search);

        if($request->page){
            $pays = Pay::latest()->whereIn('id' , $arrayFilter)->paginate($request->page);
        }else{
            $pays = Pay::latest()->whereIn('id' , $arrayFilter)->paginate(25);
        }
        $labels = ['#','شماره ﺗﺮﺍﻛﻨﺶ ﭘﺮﺩﺍﺧﺖ','وضعیت ارسال','مبلغ','شماره سفارش','وضعیت پرداخت','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Pay/PayPanel' , [
            'labels' => $labels,
            'pays' => $pays,
            'show' => $show,
            'deleted' => $deleted,
        ]);
    }

    public function show(Pay $pay){
        $payMeta = PayMeta::where('pay_id' , $pay->id)->with('post','pack')->get();
        $pays = Pay::where('id' , $pay->id)->with('carrier')->with(["user" => function($q){
            $q->with('userMeta');
        }])->first();
        return [$pays , $payMeta];
    }
    public function invoice(Pay $pay){
        if(auth()->user()){
            $carrier = Carrier::with(["pay" => function ($q) use ($pay){
                $q->where('id',$pay->id);
            }])->get();
            $title = Setting::where('key' , 'title')->pluck('value')->first();
            $logo = Setting::where('key' , 'logo')->pluck('value')->first();
            $address = Setting::where('key' , 'address')->pluck('value')->first();
            $email = Setting::where('key' , 'email')->pluck('value')->first();
            $number = Setting::where('key' , 'number')->pluck('value')->first();
            $pays = Pay::with('carrier')->where('id',$pay->id)->with(["payMeta" => function($q){
                $q->with(["post" => function($q){
                    $q->with('user');
                }]);
            }])->with(["user" => function($q){
                $q->with('userMeta');
            }])->first();
            return Inertia::render('Home/User/InvoicePay', [
                'pay' => $pays,
                'title' => $title,
                'number' => $number,
                'email' => $email,
                'address' => $address,
                'logo' => $logo,
                'carrier' => $carrier,
            ]);
        }else{
            return abort(404);
        }
    }
}
