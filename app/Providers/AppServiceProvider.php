<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Page;
use App\Models\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Setting;
use App\Models\Category;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::share('appName', config('app.name'));

// Lazily
        Inertia::share('errors', function(){
            return session()->get('errors') ? session()->get('errors')->getBag('default')->getMessages() : (object) [];
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
//
    public function boot()
    {
        Inertia::share('appName', config('app.name'));

        $catHeader1 = Setting::where('key' , 'catHeader')->pluck('value')->first();
        $catHeader = [];
        if ($catHeader1 != null){
            $allCatHeader1 = explode('[' , $catHeader1);
            $allCatHeader2 = explode(']' , $allCatHeader1[1]);
            $allCatHeader3 = explode(',' , $allCatHeader2[0]);
            foreach ($allCatHeader3 as $item){
                $send = Category::where('id' , $item)->with(["cats" => function($q){
                    $q->with(["cats" => function($q){
                        $q->with(["cats" => function($q){
                            $q->with('cats');}]);}]);}])->first();
                if($send){
                    array_push($catHeader ,$send);
                }
            }
        }
        $catFooter1 = Setting::where('key' , 'footerCat')->pluck('value')->first();
        $catFooter = [];
        if ($catFooter1 != null){
            $allCatFooter1 = explode('[' , $catFooter1);
            $allCatFooter2 = explode(']' , $allCatFooter1[1]);
            $allCatFooter3 = explode(',' , $allCatFooter2[0]);
            foreach ($allCatFooter3 as $item){
                $send = Category::where('id' , $item)->first();
                if($send){
                    array_push($catFooter ,$send);
                }
            }
        }

        Inertia::share('commentSeen', fn (Request $request) => Comment::where('seen' , 0)->get()
            ? Comment::where('seen' , 0)->count()
            : null
        );
        Inertia::share('paySeen', fn (Request $request) => Pay::where('seen' , 0)->get()
            ? Pay::where('seen' , 0)->count()
            : null
        );
        Inertia::share('userSeen', fn (Request $request) => User::where('seen' , 0)->get()
            ? User::where('seen' , 0)->count()
            : null
        );
        Inertia::share('allPages', fn (Request $request) => Page::latest()->get()
            ? Page::latest()->get()
            : []
        );
        Inertia::share('catHeader', fn (Request $request) => $catHeader
            ?$catHeader
            : []
        );
        Inertia::share('catFooter', fn (Request $request) => $catFooter
            ?$catFooter
            : []
        );

        Inertia::share('allow', fn (Request $request) => $request->user()
        ? $request->user()->getAllPermissions()
        : null
        );

        Inertia::share('aboutFooter', fn (Request $request) => Setting::where('key' , 'siteAbout')->pluck('value')->first()
            ? Setting::where('key' , 'siteAbout')->pluck('value')->first()
            : null
        );

        Inertia::share('logo', fn (Request $request) => Setting::where('key' , 'siteLogo')->pluck('value')->first()
            ? Setting::where('key' , 'siteLogo')->pluck('value')->first()
            : null
        );
        Inertia::share('etemadAddress', fn (Request $request) => Setting::where('key' , 'etemadSite')->pluck('value')->first()
            ? Setting::where('key' , 'etemadSite')->pluck('value')->first()
            : null
        );
        Inertia::share('fanavariAddress', fn (Request $request) => Setting::where('key' , 'fanavariSite')->pluck('value')->first()
            ? Setting::where('key' , 'fanavariSite')->pluck('value')->first()
            : null
        );
        Inertia::share('siteEmail', fn (Request $request) => Setting::where('key' , 'emailAddress')->pluck('value')->first()
            ? Setting::where('key' , 'emailAddress')->pluck('value')->first()
            : null
        );

        Inertia::share('numberSite', fn (Request $request) => Setting::where('key' , 'siteNumber')->pluck('value')->first()
            ? Setting::where('key' , 'siteNumber')->pluck('value')->first()
            : null
        );
        Inertia::share('userData', fn (Request $request) => $request->user()
            ? $request->user()
            : null
        );

        view()->composer('auth.login', function ($view) {
            $siteLogo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
            $captcha = Setting::where('key' , 'captcha')->pluck('value')->first();
            $google = Setting::where('key' , 'siteGM')->pluck('value')->first();
            $view->with([
                'captcha' =>$captcha,
                'siteLogo' =>$siteLogo,
                'google' =>$google,
            ]);
        });
        view()->composer('auth.forgot-password', function ($view) {
            $siteLogo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
            $view->with([
                'siteLogo' =>$siteLogo,
            ]);
        });
        view()->composer('auth.register', function ($view) {
            $siteLogo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
            $view->with([
                'siteLogo' =>$siteLogo,
            ]);
        });
        view()->composer('auth.reset-password', function ($view) {
            $siteLogo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
            $view->with([
                'siteLogo' =>$siteLogo,
            ]);
        });
        view()->composer('auth.verify-email', function ($view) {
            $siteLogo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
            $view->with([
                'siteLogo' =>$siteLogo,
            ]);
        });
    }
}
