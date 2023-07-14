<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Pay;
use App\Models\View;
use App\Models\Comment;

class PanelController extends Controller
{
    public function index(){
        $users = User::get();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id)){
                $user->update([
                    'activity' => Verta::now()->format('H:i Y-n-j')
                ]);
            }
        }
        $onlineUser = User::latest()->where('activity' , Verta::now()->format('H:i Y-n-j'))->count();
        $offUser = count($users) - $onlineUser;
        $todayUser = User::latest()->whereDate('created_at' , Carbon::now()->today())->count();
        $posts = Post::latest()->count();
        $unActivePost = Post::latest()->where('status' , 0)->count();
        $activePost = Post::latest()->where('status' , 1)->count();
        $todayPost = Post::latest()->whereDate('created_at' , Carbon::now()->today())->count();

        $pay = Pay::where('status' , '100')->pluck('price');
        $pays = 0;
        foreach ($pay as $item) {
            $pays =  $pays + (float)$item;
        }
        $payActive = Pay::where('status' , '100')->count();
        $payUnActive = Pay::where('status' , '!=' , '100')->count();

        $todayPays = Pay::whereDate('created_at' , Carbon::now()->today())->where('status' , '100')->pluck('price');
        $todayPay = 0;
        foreach ($todayPays as $item) {
            $todayPay =  $todayPay + (float)$item;
        }

        $todayView = View::whereDate('created_at' , Carbon::today())->count();
        $views = View::count();
        $androidView = View::where('platform' , 'AndroidOS')->count();
        $windowView = View::where('platform' , 'Windows')->count();

        $todayComment = Comment::whereDate('created_at' , Carbon::today())->count();
        $comments = Comment::count();
        $activeComment = Comment::where('status' , 1)->count();
        $unActiveComment = $comments - $activeComment;

        $todayBill = Pay::whereDate('created_at' , Carbon::today())->count();
        $allBill = Pay::count();
        $activeBill = Pay::where('deliver' , 1)->count();
        $unActiveBill = $allBill - $activeBill;
        
        $year = Carbon::now()->format('Y');
        $bahmanPays = Pay::whereMonth('created_at' , '1')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $bahmanPay = 0;

        foreach ($bahmanPays as $item) {
            $bahmanPay =  $bahmanPay + (float)$item;
        }
        $esfandPays = Pay::whereMonth('created_at' , '2')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $esfandPay = 0;
        foreach ($esfandPays as $item) {
            $esfandPay =  $esfandPay + (float)$item;
        }
        $farvardinPays = Pay::whereMonth('created_at' , '3')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $farvardinPay = 0;
        foreach ($farvardinPays as $item) {
            $farvardinPay =  $farvardinPay + (float)$item;
        }
        $ordibeheshtPays = Pay::whereMonth('created_at' , '4')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $ordibeheshtPay = 0;
        foreach ($ordibeheshtPays as $item) {
            $ordibeheshtPay =  $ordibeheshtPay + (float)$item;
        }

        $khordadPays = Pay::whereMonth('created_at' , '5')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $khordadPay = 0;
        foreach ($khordadPays as $item) {
            $khordadPay =  $khordadPay + (float)$item;
        }
        
        $tirPays = Pay::whereMonth('created_at' , '6')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $tirPay = 0;
        foreach ($tirPays as $item) {
            $tirPay =  $tirPay + (float)$item;
        }
        $mordadPays = Pay::whereMonth('created_at' , '7')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $mordadPay = 0;
        foreach ($mordadPays as $item) {
            $mordadPay =  $mordadPay + (float)$item;
        }
        $shahrivarPays = Pay::whereMonth('created_at' , '8')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $shahrivarPay = 0;
        foreach ($shahrivarPays as $item) {
            $shahrivarPay =  $shahrivarPay + (float)$item;
        }
        $mehrPays = Pay::whereMonth('created_at' , '9')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $mehrPay = 0;
        foreach ($mehrPays as $item) {
            $mehrPay =  $mehrPay + (float)$item;
        }
        $abanPays = Pay::whereMonth('created_at' , '10')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $abanPay = 0;
        foreach ($abanPays as $item) {
            $abanPay =  $abanPay + (float)$item;
        }
        $azarPays = Pay::whereMonth('created_at' , '11')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $azarPay = 0;
        foreach ($azarPays as $item) {
            $azarPay =  $azarPay + (float)$item;
        }
        $deyPays = Pay::whereMonth('created_at' , '12')->whereYear('created_at' , $year)->where('status' , '100')->pluck('price');
        $deyPay = 0;
        foreach ($deyPays as $item) {
            $deyPay =  $deyPay + (float)$item;
        }

        return Inertia::render('Admin/AllPanel',[
            'users' => $users,
            'todayUser' => $todayUser,
            'onlineUser' => $onlineUser,
            'offUser' => $offUser,
            'posts' => $posts,
            'unActivePost' => $unActivePost,
            'activePost' => $activePost,
            'todayPost' => $todayPost,
            'pays' => $pays,
            'payActive' => $payActive,
            'payUnActive' => $payUnActive,
            'todayPay' => $todayPay,
            'todayView' => $todayView,
            'androidView' => $androidView,
            'windowView' => $windowView,
            'views' => $views,
            'todayComment' => $todayComment,
            'comments' => $comments,
            'activeComment' => $activeComment,
            'unActiveComment' => $unActiveComment,
            'todayBill' => $todayBill,
            'allBill' => $allBill,
            'activeBill' => $activeBill,
            'unActiveBill' => $unActiveBill,
            'deyPay' => $deyPay,
            'bahmanPay' => $bahmanPay,
            'esfandPay' => $esfandPay,
            'farvardinPay' => $farvardinPay,
            'ordibeheshtPay' => $ordibeheshtPay,
            'khordadPay' => $khordadPay,
            'tirPay' => $tirPay,
            'mordadPay' => $mordadPay,
            'shahrivarPay' => $shahrivarPay,
            'mehrPay' => $mehrPay,
            'abanPay' => $abanPay,
            'azarPay' => $azarPay,
        ]);
    }
}
