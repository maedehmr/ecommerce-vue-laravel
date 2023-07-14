<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Carrier;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\PayMeta;
use App\Models\Pay;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()){
            $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
            $pays = Pay::latest()->where('user_id' , auth()->user()->id)->take(10)->get();
            $likes =  auth()->user()->like;
            $likePost = [];
            foreach ($likes as $item) {
                $posts = Post::latest()->where('id' , $item->post_id)->first();
                array_push($likePost , $posts);
            }

            $bookmarks =  auth()->user()->bookmark;
            $bookmarkPost = [];
            foreach ($bookmarks as $item) {
                $posts = Post::latest()->where('id' , $item->post_id)->first();
                array_push($bookmarkPost , $posts);
            }
            return Inertia::render('Home/User/UserIndex', [
                'pays' => $pays,
                'likePost' => $likePost,
                'bookmarkPost' => $bookmarkPost,
                'title' => $title,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function bookmark(){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
            $bookmarks =  auth()->user()->bookmark;
            $bookmarkPost = [];
            foreach ($bookmarks as $item) {
                $posts = Post::latest()->where('id' , $item->post_id)->pluck('id')->first();
                array_push($bookmarkPost , $posts);
            }

            $bookmarkPosts = Post::latest()->whereIn('id' , $bookmarkPost)->paginate($showPostPage);
            return Inertia::render('Home/User/BookmarkUser', [
                'title' => $title,
                'bookmarkPosts' => $bookmarkPosts,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function like(){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
            $likes =  auth()->user()->like;
            $likePost = [];
            foreach ($likes as $item) {
                $posts = Post::latest()->where('id' , $item->post_id)->pluck('id')->first();
                array_push($likePost , $posts);
            }

            $likePosts = Post::latest()->whereIn('id' , $likePost)->paginate($showPostPage);
            return Inertia::render('Home/User/LikeUser', [
                'title' => $title,
                'likePosts' => $likePosts,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function comment(Request $request){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
            if($request->removeId){
                Comment::where('user_id' , auth()->user()->id)->where('id' , $request->removeId)->first()->delete();
            }
            if($request->show == 0){
                $comments = Comment::where('user_id' , auth()->user()->id)->with('post')->paginate($showPostPage);
            }
            if($request->show == 1){
                $comments = Comment::where('approved' , 0)->where('user_id' , auth()->user()->id)->with('post')->paginate($showPostPage);
            }
            if($request->show == 2){
                $comments = Comment::where('approved' , 1)->where('user_id' , auth()->user()->id)->with('post')->paginate($showPostPage);
            }
            return Inertia::render('Home/User/UserComment', [
                'title' => $title,
                'comments' => $comments,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function personalInfo(Request $request){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $user = User::where('id' , auth()->user()->id)->with('userMeta')->first();
            if($request->update){
                $request->validate([
                    'date' => 'required|max:11',
                    'number' => 'required|min:8|max:11',
                    'name' => 'required|min:3|max:255',
                    'post' => 'required|min:8|max:20',
                    'job' => 'required|max:255',
                    'code' => 'required|min:10|max:11',
                    'address' => 'required|max:255',
                ]);
                $check = Auth::user()->userMeta()->count();
                if ($check >= 1){
                    if($request->password){
                        Auth::user()->update([
                            'name'=>$request->user,
                            'number'=>$request->number,
                            'email'=>$request->email,
                            'password'=> Hash::make($request->password),
                        ]);
                        Auth::user()->userMeta()->update([
                            'date'=>$request->date,
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'job'=>$request->job,
                            'code'=>$request->code,
                            'address'=>$request->address,
                        ]);
                    }else{
                        Auth::user()->update([
                            'name'=>$request->user,
                            'number'=>$request->number,
                            'email'=>$request->email,
                        ]);
                        Auth::user()->userMeta()->update([
                            'date'=>$request->date,
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'job'=>$request->job,
                            'code'=>$request->code,
                            'address'=>$request->address,
                        ]);
                    }
                }
                else{
                    if($request->password){
                        Auth::user()->update([
                            'name'=>$request->user,
                            'number'=>$request->number,
                            'email'=>$request->email,
                            'password'=> Hash::make($request->password),
                        ]);
                        $userMeta = UserMeta::create([
                            'date'=>$request->date,
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'job'=>$request->job,
                            'code'=>$request->code,
                            'address'=>$request->address,
                        ]);
                    }else{
                        Auth::user()->update([
                            'name'=>$request->user,
                            'number'=>$request->number,
                            'email'=>$request->email,
                        ]);
                        $userMeta = UserMeta::create([
                            'date'=>$request->date,
                            'name'=>$request->name,
                            'post'=>$request->post,
                            'job'=>$request->job,
                            'code'=>$request->code,
                            'address'=>$request->address,
                        ]);
                    }
                    Auth::user()->userMeta()->sync($userMeta->id);
                }
            }
            return Inertia::render('Home/User/UserInfo', [
                'title' => $title,
                'user' => $user,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function pay(Request $request){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
            if($request->show == 0){
                $pays = Pay::latest()->where('user_id' , auth()->user()->id)->paginate($showPostPage);
            }
            if($request->show == 1){
                $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('status' , 100)->paginate($showPostPage);
            }
            if($request->show == 2){
                $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('status' , '!=' , 100)->paginate($showPostPage);
            }
            if($request->show == 3){
                $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('deliver' , 1)->paginate($showPostPage);
            }
            if($request->show == 4){
                $pays = Pay::latest()->where('user_id' , auth()->user()->id)->where('deliver' , 0)->paginate($showPostPage);
            }
            return Inertia::render('Home/User/PayUser', [
                'title' => $title,
                'pays' => $pays,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function recently(){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        if(auth()->user()){
            $myViewsCheck = auth()->user()->view()->whereDate('created_at' , Carbon::today())->get();
            $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

            $views2 = [];
            for ( $i = 0; $i < count($myViewsCheck); $i++) {
                $views1 = $myViewsCheck[$i]->post()->pluck('id')->first();
                array_push($views2 ,$views1);
            }
            $views = Post::whereIn('id' , $views2)->with('color')->paginate($showPostPage);

            return Inertia::render('Home/User/ViewUser', [
                'title' => $title,
                'views' => $views,
            ]);
        }else{
            return redirect('/');
        }
    }
    public function showPay(Pay $pay){
        return PayMeta::where('pay_id' , $pay->id)->with('post','pack')->get();
    }
    public function showPay1(Pay $pay){
        $pays = Pay::where('id' , $pay->id)->with(["user" => function($q){
            $q->with('userMeta');
        }])->with(["payMeta" => function($q){
            $q->with('post');
        }])->first();
        return Inertia::render('Home/User/ShowPay',[
            'pay' => $pays
        ]);
    }
    public function invoice(Pay $pay){
        if(auth()->user()){
            if ($pay->user_id == auth()->user()->id){
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
        }else{
            return abort(404);
        }
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
