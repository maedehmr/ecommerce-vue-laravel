<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Pack;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Size;
use App\Models\Color;
use App\Models\Vidget;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    public function category(Request $request , Category $category){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $url = 'category/';
        $maxPrice = $category->post()->where('status' , 1)->orderBy('price','DESC')->pluck('price')->first();
        $minPrice = $category->post()->where('status' , 1)->orderBy('price')->pluck('price')->first();

        $suggestPost = $category->post()->where('status' , 1)->where('suggest','!=' ,null)->with('postMeta')->take(7)->get();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $showcasePost = $category->post()->where('status' , 1)->where('showcase',1)->inRandomOrder()->with('postMeta')->take($showPostCategory)->get();
        $post = $category->post()->where('status' , 1)->with('postMeta')->get();

        $color = Color::latest()->get();
        $size = Size::latest()->get();

        $ability = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $abilities = json_decode($post[$i]['postMeta'][0]['ability']);
            if ($abilities != null){
                for ( $i2 = 0; $i2 < count($abilities); $i2++) {
                    for ( $i3 = 0; $i3 < count($ability); $i3++) {
                        if ($ability[$i3] == $abilities[$i2]){
                            $check = 'yes';
                        }
                    }
                    if ($check == 'no'){
                        array_push($ability , $abilities[$i2]);
                    }
                    $check = 'no';
                }
            }
        }

        $off = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $offs = json_decode($post[$i]['off']);
            if ($offs != null){
                for ( $i2 = 0; $i2 < count($off); $i2++) {
                    if ($off[$i2] == $offs){
                        $check = 'yes';
                    }
                }
                if ($check == 'no'){
                    array_push($off , $offs);
                }
                $check = 'no';
            }
        }
        $brands = Brand::latest()->get();
        $categories = Category::where('id' , $category->id)->with(["cats" => function($q){
            $q->latest()->with('post');
        }])->first();

        if ($request->allAbility){
            $abilityId = [];
            for ( $i = 0; $i < count($post); $i++) {
                $abilitiesId = json_decode($post[$i]['postMeta'][0]['ability']);
                if ($abilitiesId != null){
                    for ( $i2 = 0; $i2 < count($abilitiesId); $i2++) {
                        for ( $i3 = 0; $i3 < count($request->allAbility); $i3++) {
                            if ($request->allAbility[$i3] == $abilitiesId[$i2]->name){
                                array_push($abilityId , $post[$i]['id']);
                            }
                        }
                    }
                }
            }
        }else{
            $abilityId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allSize){
            $sizeIds = [];
            for ( $i = 0; $i < count($request->allSize); $i++) {
                $sizeId = Size::where('id',$request->allSize[$i])->first();
                $sizePost = $sizeId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($sizePost); $i2++) {
                    array_push($sizeIds , $sizePost[$i2]['id']);
                }
            }
        }else{
            $sizeIds = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allColor){
            $colorIds = [];
            for ( $i = 0; $i < count($request->allColor); $i++) {
                $colorId = Color::where('id',$request->allColor[$i])->first();
                $colorPost = $colorId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($colorPost); $i2++) {
                    array_push($colorIds , $colorPost[$i2]['id']);
                }
            }
        }else{
            $colorIds = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->search){
            $searchId = $category->post()->latest()->where("title" , "LIKE" , "%{$request->search}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $searchId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->rangePrice){
            $rangeId = $category->post()->where('price', '>=', $request->rangePrice[0])->where('status' , 1)->where('price', '<=', $request->rangePrice[1])->pluck('id')->toArray();
        }else{
            $rangeId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allOff){
            $offId = $category->post()->whereIn('off' , $request->allOff)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $offId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->suggest){
            $suggestId = $category->post()->where('suggest' , '!=' , null)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $suggestId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->count){
            $countId = $category->post()->where('count' , '!=' , '0')->where('status' , 1)->pluck('id')->toArray();
        }else{
            $countId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allBrands){
            $brandId1 = [];
            $brandId = [];
            for ( $i = 0; $i < count($request->allBrands); $i++) {
                $brandCheck1 = Brand::where('name', $request->allBrands[$i])->first();
                $brandCheck = $brandCheck1->post()->pluck('id');
                array_push($brandId1 , $brandCheck);
            }
            for ( $i = 0; $i < count($brandId1[0]); $i++) {
                $send = Post::where('id' , $brandId1[0][$i])->pluck('id')->first();
                array_push($brandId , $send);
            }
        }else{
            $brandId = $category->post()->where('status' , 1)->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($brandId, $offId,$rangeId,$colorIds,$searchId,$countId,$suggestId,$sizeIds,$abilityId);

        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

        if ($request->show == 0){
            $catPost = $category->post()->latest()->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 2){
            $catPost = $category->post()->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 1 or $request->show == 3){
            $catPost = $category->post()->withCount('view')->orderBy('view_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 4){

            $catPost = $category->post()->orderBy('price')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 5){
            $catPost = $category->post()->orderBy('price','DESC')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        return Inertia::render('Home/Archive/AllArchive' , [
            'categories' => $categories,
            'catPost' => $catPost,
            'title' => $title,
            'minPrice' => $minPrice,
            'url' => $url,
            'maxPrice' => $maxPrice,
            'off' => $off,
            'size' => $size,
            'suggestPost' => $suggestPost,
            'showcasePost' => $showcasePost,
            'ability' => $ability,
            'brands' => $brands,
            'color' => $color,
        ]);
    }
    public function vidget(Request $request , Vidget $vidget){
        $ids = [];
        $ids2 = [];
        if($vidget['category'] != null){
            $allCatSite3 = explode(',' , $vidget['category']);
            foreach ($allCatSite3 as $value){
                $tax = Category::where('name' , $value)->first();
                $send2 = $tax->post()->pluck('id')->toArray();
                foreach ($send2 as $data){
                    array_push($ids ,$data);
                }
            }
        }
        if($vidget['brand'] != ''){
            $allBrandSite3 = explode(',' , $vidget['brand']);
            foreach ($allBrandSite3 as $value){
                $tax = Brand::where('name' , $value)->first();
                $send2 = $tax->post()->pluck('id')->toArray();
                foreach ($send2 as $data){
                    array_push($ids2 ,$data);
                }
            }
        }
        if($vidget['category'] == ''){
            $ids = Post::pluck('id')->toArray();
        }
        if($vidget['brand'] == ''){
            $ids2 = Post::pluck('id')->toArray();
        }
        $id3 = array_intersect($ids,$ids2);

        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();

        $url = 'product/';
        $maxPrice = Post::whereIn('id',$id3)->where('status' , 1)->orderBy('price','DESC')->pluck('price')->first();
        $minPrice = Post::whereIn('id',$id3)->where('status' , 1)->orderBy('price')->pluck('price')->first();

        $post = Post::whereIn('id',$id3)->where('status' , 1)->with('postMeta')->get();
        $suggestPost = Post::whereIn('id',$id3)->where('suggest' , '!=' , null)->where('status' , 1)->with('postMeta')->take(7)->get();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $showcasePost = Post::whereIn('id',$id3)->where('status' , 1)->where('showcase',1)->inRandomOrder()->with('postMeta')->take($showPostCategory)->get();
        $color = Color::latest()->get();
        $size = Size::latest()->get();


        $ability = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $abilities = json_decode($post[$i]['postMeta'][0]['ability']);
            if ($abilities != null){
                for ( $i2 = 0; $i2 < count($abilities); $i2++) {
                    for ( $i3 = 0; $i3 < count($ability); $i3++) {
                        if ($ability[$i3] == $abilities[$i2]){
                            $check = 'yes';
                        }
                    }
                    if ($check == 'no'){
                        array_push($ability , $abilities[$i2]);
                    }
                    $check = 'no';
                }
            }
        }

        $off = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $offs = json_decode($post[$i]['off']);
            if ($offs != null){
                for ( $i2 = 0; $i2 < count($off); $i2++) {
                    if ($off[$i2] == $offs){
                        $check = 'yes';
                    }
                }
                if ($check == 'no'){
                    array_push($off , $offs);
                }
                $check = 'no';
            }
        }
        $brands = [];
        $categories = ['slug' => $vidget->slug,'name' => $vidget->title];


        if ($request->allAbility){
            $abilityId = [];
            for ( $i = 0; $i < count($post); $i++) {
                $abilitiesId = json_decode($post[$i]['postMeta'][0]['ability']);
                if ($abilitiesId != null){
                    for ( $i2 = 0; $i2 < count($abilitiesId); $i2++) {
                        for ( $i3 = 0; $i3 < count($request->allAbility); $i3++) {
                            if ($request->allAbility[$i3] == $abilitiesId[$i2]->name){
                                array_push($abilityId , $post[$i]['id']);
                            }
                        }
                    }
                }
            }
        }else{
            $abilityId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allSize){
            $sizeIds = [];
            for ( $i = 0; $i < count($request->allSize); $i++) {
                $sizeId = Size::where('id',$request->allSize[$i])->first();
                $sizePost = $sizeId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($sizePost); $i2++) {
                    array_push($sizeIds , $sizePost[$i2]['id']);
                }
            }
        }else{
            $sizeIds = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allColor){
            $colorIds = [];
            for ( $i = 0; $i < count($request->allColor); $i++) {
                $colorId = Color::where('id',$request->allColor[$i])->first();
                $colorPost = $colorId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($colorPost); $i2++) {
                    array_push($colorIds , $colorPost[$i2]['id']);
                }
            }
        }else{
            $colorIds = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->search){
            $searchId = Post::whereIn('id',$id3)->latest()->where("title" , "LIKE" , "%{$request->search}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $searchId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }


        if ($request->rangePrice){
            $rangeId = Post::whereIn('id',$id3)->where('price', '>=', $request->rangePrice[0])->where('status' , 1)->where('price', '<=', $request->rangePrice[1])->pluck('id')->toArray();
        }else{
            $rangeId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allOff){
            $offId = Post::whereIn('id',$id3)->whereIn('off' , $request->allOff)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $offId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->suggest){
            $suggestId = Post::whereIn('id',$id3)->where('suggest' , '!=' , null)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $suggestId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->count){
            $countId = Post::whereIn('id',$id3)->where('count' , '!=' , '0')->where('status' , 1)->pluck('id')->toArray();
        }else{
            $countId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allBrands){
            $brandId1 = [];
            $brandId = [];
            for ( $i = 0; $i < count($request->allBrands); $i++) {
                $brandCheck1 = Brand::where('name', $request->allBrands[$i])->first();
                $brandCheck = $brandCheck1->post()->pluck('id');
                array_push($brandId1 , $brandCheck);
            }
            for ( $i = 0; $i < count($brandId1[0]); $i++) {
                $send = Post::where('id' , $brandId1[0][$i])->pluck('id')->first();
                array_push($brandId , $send);
            }
        }else{
            $brandId = Post::whereIn('id',$id3)->where('status' , 1)->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($id3,$brandId, $offId,$rangeId,$colorIds,$searchId,$countId,$suggestId,$sizeIds,$abilityId);
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

        if ($request->show == 0){
            $catPost = Post::whereIn('id',$id3)->latest()->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 2){
            $catPost = Post::whereIn('id',$id3)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 1 or $request->show == 3){
            $catPost = Post::whereIn('id',$id3)->withCount('view')->orderBy('view_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 4){
            $catPost = Post::whereIn('id',$id3)->orderBy('price')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 5){
            $catPost = Post::whereIn('id',$id3)->orderBy('price','DESC')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        return Inertia::render('Home/Archive/AllArchive',[
            'categories' => $categories,
            'suggestPost' => $suggestPost,
            'catPost' => $catPost,
            'showcasePost' => $showcasePost,
            'title' => $title,
            'minPrice' => $minPrice,
            'url' => $url,
            'maxPrice' => $maxPrice,
            'off' => $off,
            'size' => $size,
            'ability' => $ability,
            'brands' => $brands,
            'color' => $color,
        ]);
    }
    public function brand(Request $request , Brand $brand){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();

        $url = 'brand/';
        $maxPrice = $brand->post()->where('status' , 1)->orderBy('price','DESC')->pluck('price')->first();
        $minPrice = $brand->post()->where('status' , 1)->orderBy('price')->pluck('price')->first();

        $post = $brand->post()->where('status' , 1)->with('postMeta')->get();
        $suggestPost = $brand->post()->where('status' , 1)->where('suggest' , '!=' , null)->with('postMeta')->take(7)->get();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $showcasePost = $brand->post()->where('status' , 1)->where('showcase',1)->inRandomOrder()->with('postMeta')->take($showPostCategory)->get();
        $color = Color::latest()->get();
        $size = Size::latest()->get();


        $ability = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $abilities = json_decode($post[$i]['postMeta'][0]['ability']);
            if ($abilities != null){
                for ( $i2 = 0; $i2 < count($abilities); $i2++) {
                    for ( $i3 = 0; $i3 < count($ability); $i3++) {
                        if ($ability[$i3] == $abilities[$i2]){
                            $check = 'yes';
                        }
                    }
                    if ($check == 'no'){
                        array_push($ability , $abilities[$i2]);
                    }
                    $check = 'no';
                }
            }
        }

        $off = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $offs = json_decode($post[$i]['off']);
            if ($offs != null){
                for ( $i2 = 0; $i2 < count($off); $i2++) {
                    if ($off[$i2] == $offs){
                        $check = 'yes';
                    }
                }
                if ($check == 'no'){
                    array_push($off , $offs);
                }
                $check = 'no';
            }
        }
        $brands = [];
        $categories = Brand::where('id' , $brand->id)->first();


        if ($request->allAbility){
            $abilityId = [];
            for ( $i = 0; $i < count($post); $i++) {
                $abilitiesId = json_decode($post[$i]['postMeta'][0]['ability']);
                if ($abilitiesId != null){
                    for ( $i2 = 0; $i2 < count($abilitiesId); $i2++) {
                        for ( $i3 = 0; $i3 < count($request->allAbility); $i3++) {
                            if ($request->allAbility[$i3] == $abilitiesId[$i2]->name){
                                array_push($abilityId , $post[$i]['id']);
                            }
                        }
                    }
                }
            }
        }else{
            $abilityId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allSize){
            $sizeIds = [];
            for ( $i = 0; $i < count($request->allSize); $i++) {
                $sizeId = Size::where('id',$request->allSize[$i])->first();
                $sizePost = $sizeId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($sizePost); $i2++) {
                    array_push($sizeIds , $sizePost[$i2]['id']);
                }
            }
        }else{
            $sizeIds = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allColor){
            $colorIds = [];
            for ( $i = 0; $i < count($request->allColor); $i++) {
                $colorId = Color::where('id',$request->allColor[$i])->first();
                $colorPost = $colorId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($colorPost); $i2++) {
                    array_push($colorIds , $colorPost[$i2]['id']);
                }
            }
        }else{
            $colorIds = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->search){
            $searchId = $brand->post()->latest()->where("title" , "LIKE" , "%{$request->search}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $searchId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }


        if ($request->rangePrice){
            $rangeId = $brand->post()->where('price', '>=', $request->rangePrice[0])->where('status' , 1)->where('price', '<=', $request->rangePrice[1])->pluck('id')->toArray();
        }else{
            $rangeId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allOff){
            $offId = $brand->post()->whereIn('off' , $request->allOff)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $offId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->suggest){
            $suggestId = $brand->post()->where('suggest' , '!=' , null)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $suggestId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->count){
            $countId = $brand->post()->where('count' , '!=' , '0')->where('status' , 1)->pluck('id')->toArray();
        }else{
            $countId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allBrands){
            $brandId1 = [];
            $brandId = [];
            for ( $i = 0; $i < count($request->allBrands); $i++) {
                $brandCheck1 = Brand::where('name', $request->allBrands[$i])->first();
                $brandCheck = $brandCheck1->post()->pluck('id');
                array_push($brandId1 , $brandCheck);
            }
            for ( $i = 0; $i < count($brandId1[0]); $i++) {
                $send = Post::where('id' , $brandId1[0][$i])->pluck('id')->first();
                array_push($brandId , $send);
            }
        }else{
            $brandId = $brand->post()->where('status' , 1)->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($brandId, $offId,$rangeId,$colorIds,$searchId,$countId,$suggestId,$sizeIds,$abilityId);
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

        if ($request->show == 0){
            $catPost = $brand->post()->latest()->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 2){
            $catPost = $brand->post()->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 1 or $request->show == 3){
            $catPost = $brand->post()->withCount('view')->orderBy('view_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 4){
            $catPost = $brand->post()->orderBy('price')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 5){
            $catPost = $brand->post()->orderBy('price','DESC')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        return Inertia::render('Home/Archive/AllArchive' , [
            'categories' => $categories,
            'suggestPost' => $suggestPost,
            'showcasePost' => $showcasePost,
            'catPost' => $catPost,
            'title' => $title,
            'minPrice' => $minPrice,
            'url' => $url,
            'maxPrice' => $maxPrice,
            'off' => $off,
            'size' => $size,
            'ability' => $ability,
            'brands' => $brands,
            'color' => $color,
        ]);
    }
    public function search(Request $request){
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $url = 'search?searchProduct=';
        $maxPrice = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->orderBy('price','DESC')->pluck('price')->first();
        $minPrice = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->orderBy('price')->pluck('price')->first();

        $post = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->with('postMeta')->get();
        $suggestPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->where('suggest' , '!=' , null)->with('postMeta')->take(7)->get();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $showcasePost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->where('showcase',1)->inRandomOrder()->with('postMeta')->take($showPostCategory)->get();
        $color = Color::latest()->get();
        $size = Size::latest()->get();

        $ability = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $abilities = json_decode($post[$i]['postMeta'][0]['ability']);
            if ($abilities != null){
                for ( $i2 = 0; $i2 < count($abilities); $i2++) {
                    for ( $i3 = 0; $i3 < count($ability); $i3++) {
                        if ($ability[$i3] == $abilities[$i2]){
                            $check = 'yes';
                        }
                    }
                    if ($check == 'no'){
                        array_push($ability , $abilities[$i2]);
                    }
                    $check = 'no';
                }
            }
        }

        $off = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $offs = json_decode($post[$i]['off']);
            if ($offs != null){
                for ( $i2 = 0; $i2 < count($off); $i2++) {
                    if ($off[$i2] == $offs){
                        $check = 'yes';
                    }
                }
                if ($check == 'no'){
                    array_push($off , $offs);
                }
                $check = 'no';
            }
        }

        $brands = Brand::latest()->get();

        $categories = ['slug' => $request->searchProduct,'name' => $request->searchProduct];

        if ($request->allAbility){
            $abilityId = [];
            for ( $i = 0; $i < count($post); $i++) {
                $abilitiesId = json_decode($post[$i]['postMeta'][0]['ability']);
                if ($abilitiesId != null){
                    for ( $i2 = 0; $i2 < count($abilitiesId); $i2++) {
                        for ( $i3 = 0; $i3 < count($request->allAbility); $i3++) {
                            if ($request->allAbility[$i3] == $abilitiesId[$i2]->name){
                                array_push($abilityId , $post[$i]['id']);
                            }
                        }
                    }
                }
            }
        }else{
            $abilityId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allSize){
            $sizeIds = [];
            for ( $i = 0; $i < count($request->allSize); $i++) {
                $sizeId = Size::where('id',$request->allSize[$i])->first();
                $sizePost = $sizeId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($sizePost); $i2++) {
                    array_push($sizeIds , $sizePost[$i2]['id']);
                }
            }
        }else{
            $sizeIds = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allColor){
            $colorIds = [];
            for ( $i = 0; $i < count($request->allColor); $i++) {
                $colorId = Color::where('id',$request->allColor[$i])->first();
                $colorPost = $colorId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($colorPost); $i2++) {
                    array_push($colorIds , $colorPost[$i2]['id']);
                }
            }
        }else{
            $colorIds = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->search){
            $searchId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->latest()->where("title" , "LIKE" , "%{$request->search}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $searchId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }


        if ($request->rangePrice){
            $rangeId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('price', '>=', $request->rangePrice[0])->where('status' , 1)->where('price', '<=', $request->rangePrice[1])->pluck('id')->toArray();
        }else{
            $rangeId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allOff){
            $offId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->whereIn('off' , $request->allOff)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $offId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->suggest){
            $suggestId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('suggest' , '!=' , null)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $suggestId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->count){
            $countId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('count' , '!=' , '0')->where('status' , 1)->pluck('id')->toArray();
        }else{
            $countId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allBrands){
            $brandId1 = [];
            $brandId = [];
            for ( $i = 0; $i < count($request->allBrands); $i++) {
                $brandCheck1 = Brand::where('name', $request->allBrands[$i])->first();
                $brandCheck = $brandCheck1->post()->pluck('id');
                array_push($brandId1 , $brandCheck);
            }
            for ( $i = 0; $i < count($brandId1[0]); $i++) {
                $send = Post::where('id' , $brandId1[0][$i])->pluck('id')->first();
                array_push($brandId , $send);
            }
        }else{
            $brandId = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->where('status' , 1)->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($brandId, $offId,$rangeId,$colorIds,$searchId,$countId,$suggestId,$sizeIds,$abilityId);

        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

        if ($request->show == 0){
            $catPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->latest()->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 2){
            $catPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 1 or $request->show == 3){
            $catPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->withCount('view')->orderBy('view_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 4){
            $catPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->orderBy('price')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        if ($request->show == 5){
            $catPost = Post::where("title" , "LIKE" , "%{$request->searchProduct}%")->orderBy('price','DESC')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta','color')->paginate($showPostPage);
        }
        return Inertia::render('Home/Archive/AllArchive' , [
            'categories' => $categories,
            'suggestPost' => $suggestPost,
            'showcasePost' => $showcasePost,
            'catPost' => $catPost,
            'title' => $title,
            'minPrice' => $minPrice,
            'url' => $url,
            'maxPrice' => $maxPrice,
            'off' => $off,
            'size' => $size,
            'ability' => $ability,
            'brands' => $brands,
            'color' => $color,
        ]);
    }
    public function searchAdvance(Request $request){
        $showPost = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        if ($request->name){
            $name = Post::where("title" , "LIKE" , "%{$request->name}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $name = Post::where('status' , 1)->pluck('id')->toArray();
        }
        if ($request->code){
            $code = Post::where("title" , "LIKE" , "%{$request->code}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $code = Post::where('status' , 1)->pluck('id')->toArray();
        }
        if ($request->off){
            $off = Post::where("off" , $request->off)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $off = Post::where('status' , 1)->pluck('id')->toArray();
        }
        if ($request->color){
            $colorName = Color::latest()->where('name' , $request->color)->first();
            $color = $colorName->post()->pluck('id')->toArray();
        }else{
            $color = Post::latest()->where('status' , 1)->pluck('id')->toArray();
        }
        if ($request->brand){
            $brandName = Brand::latest()->where('name' , $request->brand)->first();
            $brand = $brandName->post()->pluck('id')->toArray();
        }else{
            $brand = Post::latest()->where('status' , 1)->pluck('id')->toArray();
        }
        if ($request->category){
            $categoryName = Category::latest()->where('name' , $request->category)->first();
            $category = $categoryName->post()->pluck('id')->toArray();
        }else{
            $category = Post::latest()->where('status' , 1)->pluck('id')->toArray();
        }
        $arraySearch = array_intersect($name,$brand,$color,$category,$code,$off);
        return Post::whereIn('id' , $arraySearch)->with('color')->where('status', 1)->get();
    }
    public function packs(){
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        $packs = Pack::latest()->with('post','user')->withCount('post')->paginate($showPostPage);
        return Inertia::render('Home/Archive/AllPack' , [
            'packs' => $packs,
        ]);
    }
    public function suggest(Request $request){
        $time = Carbon::now()->format('Y-m-d h:i');
        DB::table('posts')->where('suggest', '<=' , $time)->update(['suggest'=> null]);
        $title = Setting::where('key' , 'title')->pluck('value')->first();

        $url = '';
        $maxPrice = Post::where("suggest" , "!=" , null)->where('status' , 1)->orderBy('price','DESC')->pluck('price')->first();
        $minPrice = Post::where("suggest" , "!=" , null)->where('status' , 1)->orderBy('price')->pluck('price')->first();

        $post = Post::where("suggest" , "!=" , null)->where('status' , 1)->with('postMeta')->get();
        $suggestPost = Post::where("suggest" , "!=" , null)->where('status' , 1)->with('postMeta')->take(7)->get();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $showcasePost = Post::where("suggest" , "!=" , null)->where('status' , 1)->where('showcase',1)->inRandomOrder()->with('postMeta')->take($showPostCategory)->get();
        $color = Color::latest()->get();
        $size = Size::latest()->get();

        $ability = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $abilities = json_decode($post[$i]['postMeta'][0]['ability']);
            if ($abilities != null){
                for ( $i2 = 0; $i2 < count($abilities); $i2++) {
                    for ( $i3 = 0; $i3 < count($ability); $i3++) {
                        if ($ability[$i3] == $abilities[$i2]){
                            $check = 'yes';
                        }
                    }
                    if ($check == 'no'){
                        array_push($ability , $abilities[$i2]);
                    }
                    $check = 'no';
                }
            }
        }

        $off = [];
        $check = 'no';
        for ( $i = 0; $i < count($post); $i++) {
            $offs = json_decode($post[$i]['off']);
            if ($offs != null){
                for ( $i2 = 0; $i2 < count($off); $i2++) {
                    if ($off[$i2] == $offs){
                        $check = 'yes';
                    }
                }
                if ($check == 'no'){
                    array_push($off , $offs);
                }
                $check = 'no';
            }
        }

        $brands = Brand::latest()->get();
        $categories = ['slug' => 'suggest','name' => 'شگفت انگیزان'];

        if ($request->allAbility){
            $abilityId = [];
            for ( $i = 0; $i < count($post); $i++) {
                $abilitiesId = json_decode($post[$i]['postMeta'][0]['ability']);
                if ($abilitiesId != null){
                    for ( $i2 = 0; $i2 < count($abilitiesId); $i2++) {
                        for ( $i3 = 0; $i3 < count($request->allAbility); $i3++) {
                            if ($request->allAbility[$i3] == $abilitiesId[$i2]->name){
                                array_push($abilityId , $post[$i]['id']);
                            }
                        }
                    }
                }
            }
        }else{
            $abilityId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allSize){
            $sizeIds = [];
            for ( $i = 0; $i < count($request->allSize); $i++) {
                $sizeId = Size::where('id',$request->allSize[$i])->first();
                $sizePost = $sizeId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($sizePost); $i2++) {
                    array_push($sizeIds , $sizePost[$i2]['id']);
                }
            }
        }else{
            $sizeIds = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->search){
            $searchId = Post::where("suggest" , "!=" , null)->latest()->where("title" , "LIKE" , "%{$request->search}%")->where('status' , 1)->pluck('id')->toArray();
        }else{
            $searchId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allColor){
            $colorIds = [];
            for ( $i = 0; $i < count($request->allColor); $i++) {
                $colorId = Color::where('id',$request->allColor[$i])->first();
                $colorPost = $colorId->post()->where('status' , 1)->get();
                for ( $i2 = 0; $i2 < count($colorPost); $i2++) {
                    array_push($colorIds , $colorPost[$i2]['id']);
                }
            }
        }else{
            $colorIds = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->rangePrice){
            $rangeId = Post::where("suggest" , "!=" , null)->where('price', '>=', $request->rangePrice[0])->where('status' , 1)->where('price', '<=', $request->rangePrice[1])->pluck('id')->toArray();
        }else{
            $rangeId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allOff){
            $offId = Post::where("suggest" , "!=" , null)->whereIn('off' , $request->allOff)->where('status' , 1)->pluck('id')->toArray();
        }else{
            $offId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        $suggestId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();

        if ($request->count){
            $countId = Post::where("suggest" , "!=" , null)->where('count' , '!=' , '0')->where('status' , 1)->pluck('id')->toArray();
        }else{
            $countId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        if ($request->allBrands){
            $brandId1 = [];
            $brandId = [];
            for ( $i = 0; $i < count($request->allBrands); $i++) {
                $brandCheck1 = Brand::where('name', $request->allBrands[$i])->first();
                $brandCheck = $brandCheck1->post()->pluck('id');
                array_push($brandId1 , $brandCheck);
            }
            for ( $i = 0; $i < count($brandId1[0]); $i++) {
                $send = Post::where('id' , $brandId1[0][$i])->pluck('id')->first();
                array_push($brandId , $send);
            }
        }else{
            $brandId = Post::where("suggest" , "!=" , null)->where('status' , 1)->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($brandId, $offId,$rangeId,$colorIds,$searchId,$countId,$suggestId,$sizeIds,$abilityId);
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();

        if ($request->show == 0){
            $catPost = Post::where("suggest" , "!=" , null)->latest()->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta')->paginate($showPostPage);
        }
        if ($request->show == 2){
            $catPost = Post::where("suggest" , "!=" , null)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta')->paginate($showPostPage);
        }
        if ($request->show == 1 or $request->show == 3){
            $catPost = Post::where("suggest" , "!=" , null)->withCount('view')->orderBy('view_count','DESC' )->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta')->paginate($showPostPage);
        }
        if ($request->show == 4){
            $catPost = Post::where("suggest" , "!=" , null)->orderBy('price')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta')->paginate($showPostPage);
        }
        if ($request->show == 5){
            $catPost = Post::where("suggest" , "!=" , null)->orderBy('price','DESC')->whereIn('id' , $arrayFilter)->where('status' , 1)->with('postMeta')->paginate($showPostPage);
        }
        return Inertia::render('Home/Archive/AllArchive' , [
            'categories' => $categories,
            'suggestPost' => $suggestPost,
            'showcasePost' => $showcasePost,
            'catPost' => $catPost,
            'title' => $title,
            'minPrice' => $minPrice,
            'url' => $url,
            'maxPrice' => $maxPrice,
            'off' => $off,
            'size' => $size,
            'ability' => $ability,
            'brands' => $brands,
            'color' => $color,
        ]);
    }
    public function news(){
        $url = request()->path();
        $titleSite = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        $suggest = News::where('status' , 1)->where('suggest' , 1)->with('user')->latest()->take(6)->get();
        $news = News::where('status' , 1)->latest()->with('user')->paginate($showPostPage);
        return Inertia::render('Home/Archive/AllNews' , [
            'news' => $news,
            'url' => $url,
            'titleSite' => $titleSite,
            'suggest' => $suggest,
        ]);
    }

    public function newsCategory(Category $category){
        $url = request()->path();
        $titleSite = Setting::where('key' , 'siteTitle')->pluck('value')->first();
        $showPostPage = Setting::where('key' , 'showPostPage')->pluck('value')->first();
        $suggest = News::where('status' , 1)->where('suggest' , 1)->with('user')->latest()->take(6)->get();
        $news = $category->news()->where('status' , 1)->latest()->with('user')->paginate($showPostPage);
        return Inertia::render('Home/Archive/AllNews' , [
            'news' => $news,
            'url' => $url,
            'titleSite' => $titleSite,
            'suggest' => $suggest,
        ]);
    }
}
