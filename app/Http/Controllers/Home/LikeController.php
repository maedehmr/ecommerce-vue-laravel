<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        if(!$user){
            return 'noUser';
        }
        $like = Like::where('post_id' , $request->postID)->where('user_id' , $user->id)->first();
        if($like){
            $like->delete();
            return 'delete';
        }else{
            $like = Like::create([
                'user_id'=>$user->id,
                'post_id'=>$request->postID,
            ]);
            return $like;
        }
    }
    public function getLike(){
        if (auth()->user()){
            $user = auth()->user();
            return $like = Like::where('user_id' , $user->id)->pluck('post_id');
        }else{
            return [];
        }
    }
}
