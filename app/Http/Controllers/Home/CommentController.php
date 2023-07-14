<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Setting;

class CommentController extends Controller
{
    public function sendComment(Request $request){
        $user = auth()->user();
        if (!$user){
            return 'noUser';
        }else{
            $limit = Setting::where('key' , 'limitedComment')->pluck('value')->first();
            $forbiddens = Setting::where('key' , 'forbiddensComment')->pluck('value')->first();
            $commentLimited = Post::where('id' , $request->post['id'])->with(["comments" => function($q){
                $q->latest()->where('user_id' , auth()->user()->id);
            }])->first();
            $check = $commentLimited->comments->count();
            if ($check >= $limit){
                return 'limit';
            }
            else{
                $words = explode(' ' , $request->title);
                $words2 = explode(' ' , $request->body);
                $forbidden = explode(',' , $forbiddens);
                $array = array_intersect($words, $forbidden);
                $array2 = array_intersect($words2, $forbidden);

                if (count($array) == 0 && count($array2) ==0){
                    Comment::create([
                        'post_id' => $request->post['id'],
                        'user_id' => auth()->user()->id,
                        'title' => $request->title,
                        'body' => $request->body,
                        'rate' => $request->rate,
                        'name' => $request->UserName,
                        'email' => $request->emailUser,
                        'status' => $request->status,
                        'bad' => $request->bads,
                        'good' => $request->goods,
                    ]);
                    return 'success';
                }else{
                    return 'badWord' ;
                }
            }
        }
    }
    public function sendReply(Request $request){
        $user = auth()->user();
        if (!$user){
            return 'noUser';
        }else{
            $limit = Setting::where('key' , 'limitedComment')->pluck('value')->first();
            $commentLimited = Post::where('id' , $request->post['id'])->with(["comments" => function($q){
                $q->latest()->where('user_id' , auth()->user()->id);
            }])->first();
            $check = $commentLimited->comments->count();
            if ($check >= $limit){
                return 'limit';
            }
            else{
                $comment = Comment::create([
                    'post_id' => $request->post['id'],
                    'user_id' => auth()->user()->id,
                    'body' => $request->reply,
                    'parent_id'=>$request->commentId,
                ]);
                return   $commentPost= Comment::where('id' , $comment->id)->first();
            }
        }
    }
    public function getComment(Post $post){
        $approve = Setting::where('key' , 'approvedComment')->pluck('value')->first();
        $pages = Setting::where('key' , 'pagesComment')->pluck('value')->first();
        $users = User::get();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id)){
                $user->update([
                    'activity' => Verta::now()->format('H:i Y-n-j')
                ]);
            }
        }
        if ($approve == 0){
            return $comment = $post->comments()->latest()->with(["comments" => function($q){
                $q->latest();
            }])->paginate($pages);
        }else{
            return  $comment = $post->comments()->latest()->where('approved' , 1)->with(["comments" => function($q){
                $q->where('approved', '=', 1)->latest();
            }])->where('parent_id' , 1)->paginate($pages);

        }
    }
}
