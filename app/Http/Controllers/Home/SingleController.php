<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Pack;
use Inertia\Inertia;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class SingleController extends Controller
{
    public function single(Post $post){
        $users = User::get();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id)){
                $user->update([
                    'activity' => Verta::now()->format('H:i Y-n-j')
                ]);
            }
        }
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $address = Setting::where('key' , 'siteAddress')->pluck('value')->first();
        $approve = Setting::where('key' , 'approvedComment')->pluck('value')->first();
        if ($approve == 0){
            $post = Post::where('id',$post->id)->with('postMeta','category','brand','size','color')->withCount('comments')->first();
        }else{
            $post = Post::where('id' , $post->id)->with('postMeta','category','brand','size','color')->withCount(["comments" => function($q){
                $q->where('approved', 1);
            }])->first();
        }
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $related =  Post::whereHas('category', function ($q) use ($post){
            return $q->whereIn('name', $post->category()->pluck('name'));
        })->where('id' , '!=' , $post->id)->with('color','size','postMeta')->where('status' , 1)->take($showPostCategory)->get();

        $show1 = Setting::where('key' , 'checkUserComment')->pluck('value')->first();
        if ($show1 == 1){
            if (auth()->user()){
                $show = true;
            }else{
                $show = false;
            }
        }else{
            $show = true;
        }

        $reply = Setting::where('key' , 'replyComment')->pluck('value')->first();
        $coercion = Setting::where('key' , 'coercionComment')->pluck('value')->first();
        $showUser = Setting::where('key' , 'showUserComment')->pluck('value')->first();
        $checkOnline = Setting::where('key' , 'checkOnlineComment')->pluck('value')->first();
        return Inertia::render('Home/Single/AllSingle', [
            'post' => $post,
            'related' => $related,
            'address' => $address,
            'reply' => $reply,
            'coercion' => $coercion,
            'title' => $title,
            'showUser' => $showUser,
            'checkOnline' => $checkOnline,
            'show' => $show,
        ]);
    }

    public function pack(Pack $pack){
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $packs = Pack::where('id' , $pack->id)->with('post')->first();
        $new = Pack::latest()->take($showPostCategory)->get();
        return Inertia::render('Home/Single/PackSingle', [
            'packs' => $packs,
            'new' => $new,
            'title' => $title,
        ]);
    }

    public function news(News $news){
        $related =  News::whereHas('category', function ($q) use ($news){
            return $q->whereIn('name', $news->category()->pluck('name'));
        })->where('id' , '!=' , $news->id)->where('status' , 1)->take(6)->get();
        $suggest = News::where('suggest',1)->where('status',1)->latest()->get();
        $post = News::where('id',$news->id)->with('user','category')->first();
        return Inertia::render('Home/Single/SingleNews', [
            'related' => $related,
            'suggest' => $suggest,
            'post' => $post,
        ]);
    }

    public function page(Page $page){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        return Inertia::render('Home/Page/PageIndex', [
            'title' => $title,
            'page' => $page,
        ]);
    }
}
