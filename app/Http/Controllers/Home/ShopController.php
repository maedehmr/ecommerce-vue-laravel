<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use Illuminate\Http\Request;
use App\lib\zarinpal;
use App\Models\Pay;
use App\Models\PayMeta;
use App\Models\Post;
use App\Models\Setting;
use Inertia\Inertia;
use nusoap_client;

class ShopController extends Controller
{
    public function add_order(){
        $merchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        if (auth()->user()->userMeta()->count() >= 1 && auth()->user()->cart()->count() >= 1){
            $cart = auth()->user()->cart;
            if($cart[0]->delivery && $cart[0]->carrier){
                $number = auth()->user()->pluck('number')->first();
                $get1 = [];
                array_push($get1 ,Setting::where('key' , 'payDeliver')->pluck('value')->first());
                foreach ($cart as $item){
                    if ($item->post_id){
                        $send = Post::where('id' , $item->post_id)->pluck('price')->first() * $item->count;
                    }else{
                        $send = Pack::where('id' , $item->pack_id)->pluck('price')->first() * $item->count;
                    }
                    array_push($get1 ,$send);
                }
                $amount = array_sum($get1);
                $order = new zarinpal();
                $res = $order->pay($amount,auth()->user()->email,$number,'/order');
                return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $res);
            }else{
                return redirect('/user-info-cart');
            }
        }else{
            return redirect('/user-info-cart');
        }
    }

    public function order(Request $request){
        $MerchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        if (auth()->user()->userMeta()->count() >= 1 && auth()->user()->cart()->count() >= 1){
            $cart = auth()->user()->cart;
            if($cart[0]->delivery && $cart[0]->carrier) {
                $get1 = [];
                array_push($get1, Setting::where('key', 'payDeliver')->pluck('value')->first());
                foreach ($cart as $item) {
                    if ($item->post_id) {
                        $send = Post::where('id', $item->post_id)->pluck('price')->first() * $item->count;
                    } else {
                        $send = Pack::where('id', $item->pack_id)->pluck('price')->first() * $item->count;
                    }
                    array_push($get1, $send);
                }
                $Amount = array_sum($get1);
                $Authority = $request->get('Authority');
                $v = verta();
                $date = $v->format('H:i Y/n/j');
                $name = auth()->user()->name;
                if ($request->get('Status') == 'OK') {
                    $client = new nusoap_client('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
                    $client->soap_defencoding = 'UTF-8';

                    $result = $client->call('PaymentVerification', [
                        [
                            'MerchantID' => $MerchantID,
                            'Authority' => $Authority,
                            'Amount' => $Amount,
                        ],
                    ]);

                    if ($result['Status'] == 100) {
                        $chars = '012345678901234567890123456789';
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                            if (Pay::where('property', $chars2)->first()) {
                                $chars2 = substr(str_shuffle($chars), 0, 10);
                            }
                        }
                        $refs = $result['RefID'];
                        $pay = Pay::create([
                            'refId' => $result['RefID'],
                            'status' => 100,
                            'property' => $chars2,
                            'time' => $cart[0]->delivery,
                            'price' => $Amount,
                            'user_id' => auth()->user()->id,
                            'auth' => $Authority,
                        ]);
                        $pay->carrier()->sync($cart[0]['carrier'][0]['id']);
                        for ($i = 0; $i < count($cart); $i++) {
                            if ($cart[$i]->post_id) {
                                $count = Post::where('id', $cart[$i]->post_id)->pluck('count')->first();
                                Post::where('id', $cart[$i]->post_id)->first()->update([
                                    'count' => $count - $cart[$i]->count
                                ]);
                                $post = Post::where('id' , $cart[$i]->post_id)->first();
                            } else {
                                $count = Pack::where('id', $cart[$i]->pack_id)->pluck('count')->first();
                                Pack::where('id', $cart[$i]->pack_id)->first()->update([
                                    'count' => $count - $cart[$i]->count
                                ]);
                                $post = Pack::where('id' , $cart[$i]->pack_id)->first();
                            }
                            PayMeta::create([
                                'pack_id' => $cart[$i]->pack_id,
                                'post_id' => $cart[$i]->post_id,
                                'user_id' => $cart[$i]->user_id,
                                'pay_id' => $pay->id,
                                'status' => 100,
                                'price' => $post->price,
                                'count' => $cart[$i]->count,
                                'color' => $cart[$i]->color,
                                'size' => $cart[$i]->size,
                            ]);
                        }
                        auth()->user()->cart()->delete();
                        return Inertia::render('Home/Cart/BuyIndex', [
                            'name' => $name,
                            'pay' => $pay,
                        ]);

                    } else {
                        $chars = '012345678901234567890123456789';
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                            if (Pay::where('property', $chars2)->first()) {
                                $chars2 = substr(str_shuffle($chars), 0, 10);
                            }
                        }
                        $pay = Pay::create([
                            'refId' => '',
                            'status' => 0,
                            'property' => $chars2,
                            'user_id' => auth()->user()->id,
                            'price' => $Amount,
                            'auth' => $request->Authority,
                        ]);
                        for ($i = 0; $i < count($cart); $i++) {
                            if ($cart[$i]->post_id) {
                                $post = Post::where('id' , $cart[$i]->post_id)->first();
                            } else {
                                $post = Pack::where('id' , $cart[$i]->pack_id)->first();
                            }
                            PayMeta::create([
                                'pack_id' => $cart[$i]->pack_id,
                                'post_id' => $cart[$i]->post_id,
                                'user_id' => $cart[$i]->user_id,
                                'status' => 0,
                                'pay_id' => $pay->id,
                                'price' => $post->price,
                                'count' => $cart[$i]->count,
                                'color' => $cart[$i]->color,
                                'size' => $cart[$i]->size,
                            ]);
                        }
                        return Inertia::render('Home/Cart/BuyIndex', [
                            'name' => $name,
                            'pay' => $pay,
                        ]);
                    }
                } else {
                    $chars = '012345678901234567890123456789';
                    $chars2 = substr(str_shuffle($chars), 0, 10);
                    if (Pay::where('property', $chars2)->first()) {
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                        }
                    }
                    $pay = Pay::create([
                        'refId' => '',
                        'status' => '0',
                        'price' => $Amount,
                        'property' => $chars2,
                        'user_id' => auth()->user()->id,
                        'auth' => $request->Authority,
                    ]);
                    for ($i = 0; $i < count($cart); $i++) {
                        $post = Post::where('id' , $cart[$i]->post_id)->first();
                        PayMeta::create([
                            'post_id' => $cart[$i]->post_id,
                            'user_id' => $cart[$i]->user_id,
                            'pack_id' => $cart[$i]->pack_id,
                            'status' => '0',
                            'price' => $post->price,
                            'pay_id' => $pay->id,
                            'count' => $cart[$i]->count,
                            'color' => $cart[$i]->color,
                        ]);
                    }
                    return Inertia::render('Home/Cart/BuyIndex', [
                        'name' => $name,
                        'pay' => $pay,
                    ]);
                }
            }else{
                return redirect('/user-info-cart');
            }
        }else{
            return redirect('/user-info-cart');
        }
    }

    public function add_order_spot(){
        $merchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        if (auth()->user()->userMeta()->count() >= 1 && auth()->user()->cart()->count() >= 1){
            $cart = auth()->user()->cart;
            if($cart[0]->delivery && $cart[0]->carrier){
                $number = auth()->user()->pluck('number')->first();
                $get1 = [];
                array_push($get1 ,Setting::where('key' , 'payDeliver')->pluck('value')->first());
                foreach ($cart as $item){
                    if ($item->post_id){
                        $send = Post::where('id' , $item->post_id)->pluck('price')->first() * $item->count;
                    }else{
                        $send = Pack::where('id' , $item->pack_id)->pluck('price')->first() * $item->count;
                    }
                    array_push($get1 ,$send);
                }
                $amount = array_sum($get1);
                $amount = ( $amount * 10 ) / 100;
                $order = new zarinpal();
                $res = $order->pay($amount,auth()->user()->email,$number,'/spot/order');
                return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $res);
            }else{
                return redirect('/user-info-cart');
            }
        }else{
            return redirect('/user-info-cart');
        }
    }

    public function orderSpot(Request $request){
        $MerchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        if (auth()->user()->userMeta()->count() >= 1 && auth()->user()->cart()->count() >= 1){
            $cart = auth()->user()->cart;
            if($cart[0]->delivery && $cart[0]->carrier) {
                $get1 = [];
                array_push($get1, Setting::where('key', 'payDeliver')->pluck('value')->first());
                foreach ($cart as $item) {
                    if ($item->post_id) {
                        $send = Post::where('id', $item->post_id)->pluck('price')->first() * $item->count;
                    } else {
                        $send = Pack::where('id', $item->pack_id)->pluck('price')->first() * $item->count;
                    }
                    array_push($get1, $send);
                }
                $Amount = array_sum($get1);
                $Amount = ( $Amount * 10 ) / 100;
                $Authority = $request->get('Authority');
                $v = verta();
                $date = $v->format('H:i Y/n/j');
                $name = auth()->user()->name;
                if ($request->get('Status') == 'OK') {
                    $client = new nusoap_client('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
                    $client->soap_defencoding = 'UTF-8';

                    $result = $client->call('PaymentVerification', [
                        [
                            'MerchantID' => $MerchantID,
                            'Authority' => $Authority,
                            'Amount' => $Amount,
                        ],
                    ]);

                    if ($result['Status'] == 100) {
                        $chars = '012345678901234567890123456789';
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                            if (Pay::where('property', $chars2)->first()) {
                                $chars2 = substr(str_shuffle($chars), 0, 10);
                            }
                        }
                        $pay = Pay::create([
                            'refId' => $result['RefID'],
                            'status' => 50,
                            'property' => $chars2,
                            'time' => $cart[0]->delivery,
                            'deposit' => $Amount,
                            'price' => array_sum($get1),
                            'method' => 2,
                            'user_id' => auth()->user()->id,
                            'auth' => $Authority,
                        ]);
                        $pay->carrier()->sync($cart[0]['carrier'][0]['id']);
                        for ($i = 0; $i < count($cart); $i++) {
                            if ($cart[$i]->post_id) {
                                $count = Post::where('id', $cart[$i]->post_id)->pluck('count')->first();
                                Post::where('id', $cart[$i]->post_id)->first()->update([
                                    'count' => $count - $cart[$i]->count
                                ]);
                            } else {
                                $count = Pack::where('id', $cart[$i]->pack_id)->pluck('count')->first();
                                Pack::where('id', $cart[$i]->pack_id)->first()->update([
                                    'count' => $count - $cart[$i]->count
                                ]);
                            }
                            $post = Post::where('id' , $cart[$i]->post_id)->first();
                            PayMeta::create([
                                'pack_id' => $cart[$i]->pack_id,
                                'post_id' => $cart[$i]->post_id,
                                'user_id' => $cart[$i]->user_id,
                                'pay_id' => $pay->id,
                                'status' => 50,
                                'price' => $post->price,
                                'count' => $cart[$i]->count,
                                'color' => $cart[$i]->color,
                                'size' => $cart[$i]->size,
                            ]);
                        }
                        auth()->user()->cart()->delete();
                        return Inertia::render('Home/Cart/BuyIndex', [
                            'name' => $name,
                            'pay' => $pay,
                        ]);

                    } else {
                        $chars = '012345678901234567890123456789';
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                            if (Pay::where('property', $chars2)->first()) {
                                $chars2 = substr(str_shuffle($chars), 0, 10);
                            }
                        }
                        $pay = Pay::create([
                            'refId' => '',
                            'status' => 0,
                            'property' => $chars2,
                            'user_id' => auth()->user()->id,
                            'deposit' => $Amount,
                            'price' => array_sum($get1),
                            'method' => 2,
                            'auth' => $request->Authority,
                        ]);
                        for ($i = 0; $i < count($cart); $i++) {
                            $post = Post::where('id' , $cart[$i]->post_id)->first();
                            PayMeta::create([
                                'pack_id' => $cart[$i]->pack_id,
                                'post_id' => $cart[$i]->post_id,
                                'user_id' => $cart[$i]->user_id,
                                'status' => 0,
                                'pay_id' => $pay->id,
                                'price' => $post->price,
                                'count' => $cart[$i]->count,
                                'color' => $cart[$i]->color,
                                'size' => $cart[$i]->size,
                            ]);
                        }
                        return Inertia::render('Home/Cart/BuyIndex', [
                            'name' => $name,
                            'pay' => $pay,
                        ]);
                    }
                } else {
                    $chars = '012345678901234567890123456789';
                    $chars2 = substr(str_shuffle($chars), 0, 10);
                    if (Pay::where('property', $chars2)->first()) {
                        $chars2 = substr(str_shuffle($chars), 0, 10);
                        if (Pay::where('property', $chars2)->first()) {
                            $chars2 = substr(str_shuffle($chars), 0, 10);
                        }
                    }
                    $pay = Pay::create([
                        'refId' => '',
                        'status' => 0,
                        'deposit' => $Amount,
                        'price' => array_sum($get1),
                        'method' => 2,
                        'property' => $chars2,
                        'user_id' => auth()->user()->id,
                        'auth' => $request->Authority,
                    ]);
                    for ($i = 0; $i < count($cart); $i++) {
                        $post = Post::where('id' , $cart[$i]->post_id)->first();
                        PayMeta::create([
                            'post_id' => $cart[$i]->post_id,
                            'user_id' => $cart[$i]->user_id,
                            'pack_id' => $cart[$i]->pack_id,
                            'status' => '0',
                            'price' => $post->price,
                            'pay_id' => $pay->id,
                            'count' => $cart[$i]->count,
                            'color' => $cart[$i]->color,
                        ]);
                    }
                    return Inertia::render('Home/Cart/BuyIndex', [
                        'name' => $name,
                        'pay' => $pay,
                    ]);
                }
            }else{
                return redirect('/user-info-cart');
            }
        }else{
            return redirect('/user-info-cart');
        }
    }
}
