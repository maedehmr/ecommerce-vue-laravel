<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use App\Models\User;
use App\Models\Time;
use App\Models\Pack;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Cart;
use App\Models\UserMeta;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;

class CartController extends Controller
{
    public function changeCarrier(Request $request){
        foreach (auth()->user()->cart as $value) {
            $value->carrier()->detach();
            $value->carrier()->sync($request->carrier);
        }
    }
    public function changeTimeDelivery(Request $request){
        foreach (auth()->user()->cart as $value) {
            $value->update([
                'delivery' => $request->time
            ]);
        }
    }
    public function addCart(Request $request){
        $post = Post::where('id' , $request->postID)->first();
        $colorName = $post->color()->pluck('name')->first();
        $size = $post->size()->pluck('name')->first();

        if (auth()->user()){
            $cart = Cart::where('post_id' , $request->postID)->where('user_id' , auth()->user()->id)->get();
            if (count($cart) >= 1) {
                $countCheck = Post::where('id' , $cart[0]->post_id)->pluck('count')->first();
                $cartCount = 0;
                for ( $i = 0; $i < count($cart); $i++) {
                    $cartCount = $cartCount + $cart[$i]->count;
                }
            }else{
                $countCheck = 100;
                $cartCount = 0;
            }
            if ($countCheck - $cartCount >= 1) {
                $check = Cart::where('post_id' , $request->postID)->where('user_id' , auth()->user()->id)->where('color' , $colorName)->where('size' , $size)->first();
                if ($check){
                    $check->update([
                        'count' => ++$check->count
                    ]);
                    return 'success';
                }else{
                    Cart::create([
                        'post_id' => $request->postID ,
                        'user_id' => auth()->user()->id ,
                        'color'=> $colorName,
                        'size'=> $size,
                        'count' => '1' ,
                    ]);
                }
            }
            else{
                return 'limit';
            }
        }else{
            $myCart = $request->cookie('myCart');
            if(!empty($myCart)){
                if ($myCart){
                    $changeCart = [];
                    foreach(json_decode($myCart , true) as $item) {
                        if ($item['id'] == $request->postID && $size == $item['size'] && $colorName == $item['color']) {
                            $count = ++$item['count'];
                            $cartItem = [
                                'id' => $item['id'],
                                'count' => $count,
                                'color' => $item['color'],
                                'size' => $item['size'],
                            ];
                            array_push($changeCart, $cartItem);
                        } else {
                            array_push($changeCart, $item);
                        }
                    }
                    $c = collect($changeCart);
                    $filtered = $c->where('id', '=' , $request->postID)->where('size', '=' , $size)->where('color', '=' , $colorName)->first();
                    if(!$filtered){
                        $cart=[
                            'id' => $request->postID,
                            'count' => 1,
                            'color' => $colorName,
                            'size' => $size,
                        ];
                        array_push($changeCart, $cart);
                    }
                    $response = new Response('success');
                    return $response->withCookie(cookie('myCart', json_encode($changeCart), 500));
                }else{
                    $cart=[
                        'id' => $request->postID,
                        'count' => 1,
                        'color' => $colorName,
                        'size' => $size,
                    ];
                    $response = new Response('success');
                    return $response->withCookie(cookie('myCart', json_encode([$cart]) , 500));
                }
            }else{
                $cart=[
                    'id' => $request->postID,
                    'count' => 1,
                    'color' => $colorName,
                    'size' => $size,
                ];
                $response = new Response('success');
                return $response->withCookie(cookie('myCart', json_encode([$cart]) , 500));
            }
        }
    }
    public function addPack(Request $request){
        if (auth()->user()){
            $cart = Cart::where('pack_id' , $request->packID)->where('user_id' , auth()->user()->id)->get();
            if (count($cart) >= 1) {
                $countCheck = Pack::where('id' , $cart[0]->pack_id)->pluck('count')->first();
                $cartCount = 0;
                for ( $i = 0; $i < count($cart); $i++) {
                    $cartCount = $cartCount + $cart[$i]->count;
                }
            }else{
                $countCheck = 100;
                $cartCount = 0;
            }
            if ($countCheck - $cartCount >= 1) {
                $check = Cart::where('pack_id' , $request->packID)->where('user_id' , auth()->user()->id)->first();
                if ($check){
                    $check->update([
                        'count' => ++$check->count
                    ]);
                    return 'success';
                }else{
                    Cart::create([
                        'pack_id' => $request->packID,
                        'user_id' => auth()->user()->id,
                        'count' => '1' ,
                    ]);
                }
            }
            else{
                return 'limit';
            }
        }else{
            return 'no';
        }
    }
    public function addCartSingle(Request $request){
        if (auth()->user()){
            $cart = Cart::where('post_id' , $request->postID)->where('user_id' , auth()->user()->id)->get();
            if (count($cart) >= 1) {
                $countCheck = Post::where('id' , $cart[0]->post_id)->pluck('count')->first();
                $cartCount = 0;
                for ( $i = 0; $i < count($cart); $i++) {
                    $cartCount = $cartCount + $cart[$i]->count;
                }
            }else{
                $countCheck = 100;
                $cartCount = 0;
            }
            if ($countCheck - $cartCount >= 1) {
                $check = Cart::where('post_id' , $request->postID)->where('user_id' , auth()->user()->id)->where('color' , $request->color)->where('size' , $request->size)->first();
                if ($check){
                    $check->update([
                        'count' => ++$check->count
                    ]);
                    return 'success';
                }
                else{
                    Cart::create([
                        'post_id' => $request->postID ,
                        'user_id' => auth()->user()->id ,
                        'color'=> $request->color,
                        'size'=> $request->size,
                        'count' => '1' ,
                    ]);
                }
            }else{
                return 'limit';
            }
        }else{
            $myCart = $request->cookie('myCart');
            if(!empty($myCart)){
                if ($myCart){
                    $changeCart = [];
                    foreach(json_decode($myCart , true) as $item) {
                        if ($item['id'] == $request->postID && $request->size == $item['size'] && $request->color == $item['color']) {
                            $count = ++$item['count'];
                            $cartItem = [
                                'id' => $item['id'],
                                'count' => $count,
                                'color' => $item['color'],
                                'size' => $item['size'],
                            ];
                            array_push($changeCart, $cartItem);
                        } else {
                            array_push($changeCart, $item);
                        }
                    }
                    $c = collect($changeCart);
                    $filtered = $c->where('id', '=' , $request->postID)->where('size', '=' , $request->size)->where('color', '=' , $request->color)->first();
                    if(!$filtered){
                        $cart=[
                            'id' => $request->postID,
                            'count' => 1,
                            'color' => $request->color,
                            'size' => $request->size,
                        ];
                        array_push($changeCart, $cart);
                    }
                    $response = new Response('success');
                    return $response->withCookie(cookie('myCart', json_encode($changeCart), 500));
                }else{
                    $cart=[
                        'id' => $request->postID,
                        'count' => 1,
                        'color' => $request->color,
                        'size' => $request->size,
                    ];
                    $response = new Response('success');
                    return $response->withCookie(cookie('myCart', json_encode([$cart]) , 500));
                }
            }else{
                $cart=[
                    'id' => $request->postID,
                    'count' => 1,
                    'color' => $request->color,
                    'size' => $request->size,
                ];
                $response = new Response('success');
                return $response->withCookie(cookie('myCart', json_encode([$cart]) , 500));
            }
        }
    }
    public function cart(){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        return Inertia::render('Home/Cart/CartIndex' , [
            'title' => $title,
        ]);
    }
    public function getCarts(){
        $sends = Setting::where('key' , 'payDeliver')->pluck('value')->first();
        if (auth()->user()){
            $count = auth()->user()->cart()->with('carrier')->get();
            for ( $i = 0; $i < count($count); $i++) {
                if ($count[$i]->post_id != null){
                    $countCheck = Post::where('id' , $count[$i]->post_id)->pluck('count')->first();
                    if($countCheck - $count[$i]->count < 0){
                        $count[$i]->delete();
                    }
                }
                if ($count[$i]->pack_id != null){
                    $countCheck = Pack::where('id' , $count[$i]->pack_id)->pluck('count')->first();
                    if($countCheck - $count[$i]->count < 0){
                        $count[$i]->delete();
                    }
                }
            };
            $carts = [];
            foreach ($count as $item){
                if ($item['post_id']){
                    $send = Post::where('id' , $item['post_id'])->first();
                    array_push($carts ,$send);
                }
                if ($item['pack_id']){
                    $send = Pack::where('id' , $item['pack_id'])->first();
                    array_push($carts ,$send);
                }
            };
        }else{
            $value = request()->cookie('myCart');
            $count = json_decode($value,true);
            $cart = collect(json_decode($value , true))->pluck('id');
            $carts = [];
            foreach ($cart as $item) {
                $send = Post::where('id', $item)->with('user')->first();
                array_push($carts, $send);
            };
        }
        return [$carts , $count,$sends];
    }
    public function changeCarts(Request $request){
        if($request->size != null || $request->size != ''){
            $size = $request->size;
        }else{
            $size = null;
        }
        if($request->color != null || $request->color != ''){
            $color = $request->color;
        }else{
            $color = null;
        }
        if($request->pack >= 1){
            $post = Pack::where('id', $request->product)->pluck('count')->first();
            if ($request->change == 0){
                if(auth()->user()){
                    $cart = Cart::where('pack_id', $request->product)->where('user_id', auth()->user()->id)->first();
                    if ($cart->count == 1) {
                        $cart->delete();
                    } else {
                        $cart->update([
                            'count' => --$cart->count
                        ]);
                    }
                }
            }
            else{
                if(auth()->user()){
                    if($request)
                        $cart = Cart::where('pack_id', $request->product)->where('user_id', auth()->user()->id)->first();
                    if ($post - $cart->count >= 1) {
                        $cart->update([
                            'count' => ++$cart->count
                        ]);
                        return 'success';
                    } else {
                        return 'limit';
                    }
                }
            }
        }else{
            $post = Post::where('id', $request->product)->pluck('count')->first();
            if ($request->change == 0){
                if(auth()->user()){
                    $cart = Cart::where('post_id', $request->product)->where(function ($query) use ($size) {
                        $query->where('size', $size)
                            ->orWhereNull('size');
                    })->where(function ($query) use ($color) {
                        $query->where('color', $color)
                            ->orWhereNull('color');
                    })->where('user_id', auth()->user()->id)->first();
                    if ($cart->count == 1) {
                        $cart->delete();
                    } else {
                        $cart->update([
                            'count' => --$cart->count
                        ]);
                    }
                }
                $myCart = request()->cookie('myCart');
                if(!empty($myCart)){
                    if ($myCart){
                        $changeCart = [];
                        foreach(json_decode($myCart , true) as $item) {
                            if ($item['id'] == $request->product && $size == $item['size'] && $color == $item['color']) {
                                if ($item['count'] == 1) {
                                } else {
                                    $count = --$item['count'];
                                    $cartItem = [
                                        'id' => $item['id'],
                                        'count' => $count,
                                        'color' => $item['color'],
                                        'size' => $item['size'],
                                    ];
                                    array_push($changeCart, $cartItem);
                                }
                            } else {
                                array_push($changeCart, $item);
                            }
                        }
                        $c = collect($changeCart);
                        $response = new Response('success');
                        return $response->withCookie(cookie('myCart', json_encode($changeCart), 500));
                    }
                }
            }
            else{
                if(auth()->user()){
                    $cart = Cart::where('post_id', $request->product)->where(function ($query) use ($size) {
                        $query->where('size', $size)
                            ->orWhereNull('size');
                    })->where(function ($query) use ($color) {
                        $query->where('color', $color)
                            ->orWhereNull('color');
                    })->where('user_id', auth()->user()->id)->first();
                    if ($post - $cart->count >= 1) {
                        $cart->update([
                            'count' => ++$cart->count
                        ]);
                        return 'success';
                    } else {
                        return 'limit';
                    }
                }
                $myCart = request()->cookie('myCart');
                if(!empty($myCart)){
                    if ($myCart){
                        $changeCart = [];
                        foreach(json_decode($myCart , true) as $item) {
                            if ($item['id'] == $request->product && $size == $item['size'] && $color == $item['color']) {
                                if ($post - $item['count'] >= 1) {
                                    $count = ++$item['count'];
                                } else {
                                    $count = $item['count'];
                                }
                                $cartItem = [
                                    'id' => $item['id'],
                                    'count' => $count,
                                    'color' => $item['color'],
                                    'size' => $item['size'],
                                ];
                                array_push($changeCart, $cartItem);
                            } else {
                                array_push($changeCart, $item);
                            }
                        }
                        $c = collect($changeCart);
                        $response = new Response('success');
                        return $response->withCookie(cookie('myCart', json_encode($changeCart), 500));
                    }
                }
            }
        }
    }
    public function userInfoCart(Request $request){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if (Auth::user()){
            $carts = auth()->user()->cart;
            if (count($carts) >= '1'){
                if($request->update){
                    $request->validate([
                        'name' => 'required|min:2|max:255',
                        'post' => 'required|min:8|max:20',
                        'address' => 'required|max:255',
                    ]);
                    $check = Auth::user()->userMeta()->count();
                    if ($check >= 1){
                        Auth::user()->update([
                            'number'=>$request->number,
                        ]);
                        Auth::user()->userMeta()->update([
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'address'=>$request->address,
                        ]);
                    }
                    else{
                        Auth::user()->update([
                            'number'=>$request->number,
                        ]);
                        $userMeta = UserMeta::create([
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'address'=>$request->address,
                        ]);
                        Auth::user()->userMeta()->sync($userMeta->id);
                    }
                }
                $users1 = User::where('id' , auth()->user()->id)->first();
                $users = $users1->userMeta()->first();
                $number = $users1->number;
                $cart = auth()->user()->cart()->pluck('post_id');
                $posts = Post::whereIn('id', $cart)->with('time')->get();
                $ids = [];
                foreach ($posts as $item){
                    if(count($item['time']) >= 1){
                        $id = $item['time'][0]['id'];
                        array_push($ids , $id);
                    }
                }
                $times = Time::whereIn('id' , $ids)->orderBy('day','DESC' )->first();
                $days = [];
                if ($times){
                    for ( $i = $times['day']; $i < $times['day']+5; $i++) {
                        $v = new Verta('+'.$i . "day");
                        $date = [
                            'dayL'=> '',
                            'to'=> $times['to'],
                            'from'=> $times['from'],
                            'day'=> $v->day -1,
                            'month'=> $v->format('%B'),
                            'timestamp'=> $v->timestamp,
                        ];
                        $day = Carbon::instance($v)->format('l');
                        if($day == 'Saturday'){
                            $date['dayL'] = 'شنبه';
                        }
                        if($day == 'Sunday'){
                            $date['dayL'] = 'یکشنبه';
                        }
                        if($day == 'Monday'){
                            $date['dayL'] = 'دوشنبه';
                        }
                        if($day == 'Tuesday'){
                            $date['dayL'] = 'سه شنبه';
                        }
                        if($day == 'Wednesday'){
                            $date['dayL'] = 'چهار شنبه';
                        }
                        if($day == 'Thursday'){
                            $date['dayL'] = 'پنجشنبه';
                        }
                        if($day == 'Friday'){
                            $date['dayL'] = 'جمعه';
                        }
                        array_push($days , $date);
                    }
                }
                $carriers = Carrier::latest()->get();
                if(count($carts[0]->carrier) == 0){
                    foreach ($carts as $item){
                        $item->carrier()->sync($carriers[0]['id']);
                    }
                }
                return Inertia::render('Home/Cart/UserCart', [
                    'title' => $title,
                    'users' => $users,
                    'number' => $number,
                    'carriers' => $carriers,
                    'days' => $days,
                ]);
            }
            else{
                return redirect('/');
            }
        }
        return redirect('/login');
    }
    public function deleteCart(Request $request){
        if($request->size != null || $request->size != ''){
            $size = $request->size;
        }else{
            $size = null;
        }
        if($request->color != null || $request->color != ''){
            $color = $request->color;
        }else{
            $color = null;
        }
        if(auth()->user()){
            if($request->pack >= 1){
                $cart = Cart::where('pack_id', $request->product)->where('user_id', auth()->user()->id)->first();
                if($cart){
                    $cart->delete();
                }
            }else{
                $cart = Cart::where('post_id', $request->product)->where(function ($query) use ($size) {
                    $query->where('size', $size)
                        ->orWhereNull('size');
                })->where(function ($query) use ($color) {
                    $query->where('color', $color)
                        ->orWhereNull('color');
                })->where('user_id', auth()->user()->id)->first();
                if($cart){
                    $cart->delete();
                }
            }
        }
        $myCart = request()->cookie('myCart');
        if(!empty($myCart)){
            if ($myCart){
                $changeCart = [];
                foreach(json_decode($myCart , true) as $item) {
                    if ($item['id'] == $request->product && $size == $item['size'] && $color == $item['color']) {

                    } else {
                        array_push($changeCart, $item);
                    }
                }
                $c = collect($changeCart);
                $response = new Response('success');
                return $response->withCookie(cookie('myCart', json_encode($changeCart), 500));
            }
        }
    }
}
