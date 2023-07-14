<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bookmark;

class BookmarkController extends Controller
{
    public function store(Request $request){
        $user = auth()->user();
        if(!$user){
            return 'noUser';
        }
        $bookmark = Bookmark::where('post_id' , $request->postID)->where('user_id' , $user->id)->first();
        if($bookmark){
            $bookmark->delete();
            return 'delete';
        }else{
            $bookmark = Bookmark::create([
                'user_id'=>$user->id,
                'post_id'=>$request->postID,
            ]);
            return $bookmark;
        }
    }
    public function getBookmark(){
        if (auth()->user()){
            $user = auth()->user();
            return $like = Bookmark::where('user_id' , $user->id)->pluck('post_id');
        }else{
            return [];
        }
    }
}
