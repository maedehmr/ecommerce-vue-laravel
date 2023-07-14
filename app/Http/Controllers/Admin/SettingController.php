<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    public function site(Request $request){
        if($request->update){
            $showPostCategory = $request->showPostCategory;
            $showPostPage = $request->showPostPage;
            $number = $request->number;
            $facebook = $request->facebook;
            $instagram = $request->instagram;
            $twitter = $request->twitter;
            $telegram = $request->telegram;
            $logo = $request->image;
            $about = $request->about;
            $title = $request->title;
            $verifyEmail = $request->verifyEmail;
            $payDeliver = $request->payDeliver;
            $merchantID = $request->merchantID;
            $address = $request->address;
            $captcha = $request->captcha;
            $role = $request->role;
            $gm = $request->gm;
            $verify = $request->verify;
            $name = $request->name;
            $email = $request->email;
            $productId = $request->productId;
            $samandehi = $request->samandehi;
            $etemad = $request->etemad;
            $category1 = $request->category;
            $category2 = implode(',' , $category1);
            $category = '['.$category2.']';
            $categoryF1 = $request->categoryF;
            $categoryF2 = implode(',' , $categoryF1);
            $categoryF = '['.$categoryF2.']';
            $array = [
                'productId' =>$productId,
                'catHeader' =>$category,
                'footerCat' =>$categoryF,
                'samandehi' =>$samandehi,
                'etemad' =>$etemad,
                'merchantID' =>$merchantID,
                'payDeliver' =>$payDeliver,
                'verifyEmail' =>$verifyEmail,
                'showPostCategory' =>$showPostCategory,
                'showPostPage' =>$showPostPage,
                'siteName' =>$name,
                'siteTelegram' =>$telegram,
                'siteTwitter' =>$twitter,
                'siteInstagram' =>$instagram,
                'siteFacebook' =>$facebook,
                'siteNumber' =>$number,
                'siteLogo' =>$logo,
                'siteAbout' =>$about,
                'siteTitle' =>$title,
                'siteAddress' =>$address,
                'captcha' =>$captcha,
                'siteRole' =>$role,
                'emailAddress' =>$email,
                'siteGM' =>$gm,
                'verifyLogin' =>$verify,
            ];
            foreach ($array as $key=>$item){
                $setting = Setting::where('key' , $key)->first();
                if ($setting != ''){
                    $setting->update([
                        'value'=>$item,
                    ]);
                }
            }
        }
        $logo = Setting::where('key' , 'siteLogo')->pluck('value')->first();
        $about = Setting::where('key' , 'siteAbout')->pluck('value')->first();
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $address = Setting::where('key' , 'siteAddress')->pluck('value')->first();
        $email = Setting::where('key' , 'emailAddress')->pluck('value')->first();
        $captcha = Setting::where('key' , 'captcha')->pluck('value')->first();
        $role = Setting::where('key' , 'siteRole')->pluck('value')->first();
        $gm = Setting::where('key' , 'siteGM')->pluck('value')->first();
        $number = Setting::where('key' , 'siteNumber')->pluck('value')->first();
        $merchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        $facebook = Setting::where('key' , 'siteFacebook')->pluck('value')->first();
        $instagram = Setting::where('key' , 'siteInstagram')->pluck('value')->first();
        $twitter = Setting::where('key' , 'siteTwitter')->pluck('value')->first();
        $telegram = Setting::where('key' , 'siteTelegram')->pluck('value')->first();
        $verify = Setting::where('key' , 'verifyLogin')->pluck('value')->first();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $verifyEmail = Setting::where('key' , 'verifyEmail')->pluck('value')->first();
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        $name = Setting::where('key' , 'siteName')->pluck('value')->first();
        $payDeliver = Setting::where('key' , 'payDeliver')->pluck('value')->first();
        $productId = Setting::where('key' , 'productId')->pluck('value')->first();
        $samandehi = Setting::where('key' , 'samandehi')->pluck('value')->first();
        $etemad = Setting::where('key' , 'etemad')->pluck('value')->first();
        $categories = Category::latest()->pluck('name' , 'id');
        $category1 = Setting::where('key' , 'catHeader')->pluck('value')->first();
        $category2 = explode('[' , $category1);
        $category = [];
        if(count($category2) >= 1 && $category1){
            $category3 = explode(']' , $category2[1]);
            $category4 = explode(',' , $category3[0]);
            $category = Category::whereIn('id' , $category4)->get();
        }
        $categoryF1 = Setting::where('key' , 'footerCat')->pluck('value')->first();
        $categoryF2 = explode('[' , $categoryF1);
        $categoryF = [];
        if(count($categoryF2) >= 1 && $categoryF1){
            $categoryF3 = explode(']' , $categoryF2[1]);
            $categoryF4 = explode(',' , $categoryF3[0]);
            $categoryF = Category::whereIn('id' , $categoryF4)->get();
        }
        $roles = Role::latest()->get();
        return Inertia::render('Admin/Setting/SiteSetting' , [
            'productId' => $productId,
            'categories' => $categories,
            'category' => $category,
            'categoryF' => $categoryF,
            'etemad' => $etemad,
            'samandehi' => $samandehi,
            'merchantID' => $merchantID,
            'payDeliver' => $payDeliver,
            'name' => $name,
            'verifyEmail' => $verifyEmail,
            'number' => $number,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'telegram' => $telegram,
            'roles' => $roles,
            'logo' => $logo,
            'about' => $about,
            'title' => $title,
            'address' => $address,
            'email' => $email,
            'captcha' => $captcha,
            'role' => $role,
            'gm' => $gm,
            'verify' => $verify,
            'showPostCategory' => $showPostCategory,
            'showPostPage' => $showPostPage,
        ]);
    }
    public function comment(Request $request){
        if($request->update){
            $forbiddens = $request->forbiddens;
            $showUser = $request->showUser;
            $limited = $request->limited;
            $pages = $request->pages;
            $approved = $request->approved;
            $reply = $request->reply;
            $coercion = $request->coercion;
            $checkUser = $request->checkUser;
            $checkOnline = $request->checkOnline;
            $array = [
                'forbiddensComment' =>$forbiddens,
                'showUserComment' =>$showUser,
                'limitedComment' =>$limited,
                'pagesComment' =>$pages,
                'approvedComment' =>$approved,
                'replyComment' =>$reply,
                'coercionComment' =>$coercion,
                'checkUserComment' =>$checkUser,
                'checkOnlineComment' =>$checkOnline,
            ];
            foreach ($array as $key=>$item){
                $setting = Setting::where('key' , $key)->first();
                if ($setting != ''){
                    $setting->update([
                        'value'=>$item,
                    ]);
                }
            }
        }
        $forbidden = Setting::where('key' , 'forbiddensComment')->pluck('value')->first();
        $show = Setting::where('key' , 'showUserComment')->pluck('value')->first();
        $limit = Setting::where('key' , 'limitedComment')->pluck('value')->first();
        $page = Setting::where('key' , 'pagesComment')->pluck('value')->first();
        $approve = Setting::where('key' , 'approvedComment')->pluck('value')->first();
        $replay = Setting::where('key' , 'replyComment')->pluck('value')->first();
        $coercions = Setting::where('key' , 'coercionComment')->pluck('value')->first();
        $check = Setting::where('key' , 'checkUserComment')->pluck('value')->first();
        $online = Setting::where('key' , 'checkOnlineComment')->pluck('value')->first();
        return Inertia::render('Admin/Setting/CommentSetting' , [
            'forbidden' => $forbidden,
            'show' => $show,
            'limit' => $limit,
            'page' => $page,
            'approve' => $approve,
            'replay' => $replay,
            'coercions' => $coercions,
            'check' => $check,
            'online' => $online,
        ]);
    }
    public function seo(Request $request){
        if($request->update){
            $titleSeo = $request->titleSeo;
            $keywords = $request->keywords;
            $descriptionSeo = $request->descriptionSeo;
            $array = [
                'descriptionSeo' =>$descriptionSeo,
                'keywords' =>$keywords,
                'titleSeo' =>$titleSeo,
            ];
            foreach ($array as $key=>$item){
                $setting = Setting::where('key' , $key)->first();
                if ($setting != ''){
                    $setting->update([
                        'value'=>$item,
                    ]);
                }
            }
        }
        $titleSeo = Setting::where('key' , 'titleSeo')->pluck('value')->first();
        $keywords = Setting::where('key' , 'keywords')->pluck('value')->first();
        $descriptionSeo = Setting::where('key' , 'descriptionSeo')->pluck('value')->first();
        return Inertia::render('Admin/Setting/SeoSetting' , [
            'titleSeo' => $titleSeo,
            'keywords' => $keywords,
            'descriptionSeo' => $descriptionSeo,
        ]);
    }
}
