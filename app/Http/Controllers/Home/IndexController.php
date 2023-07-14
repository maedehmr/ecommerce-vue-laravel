<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Vidget;
use App\Models\Setting;
use App\Models\Pack;

class IndexController extends Controller
{
    public function index(){
        $time = Carbon::now()->format('Y-m-d h:i');
        $title = Setting::where('key' , 'siteTitle')->pluck('value')->first();

        $vidgets = Vidget::get();
        $vidget = [];
        foreach ($vidgets as $item){
            $vidgetCategory = [
                'name'=> $item['name'],
                'title'=> $item['title'],
                'more'=> $item['more'],
                'slug'=> $item['slug'],
                'show'=> $item['show'],
                'background'=> $item['background'],
                'type'=> $item['type'],
                'count'=> $item['count'],
                'post'=> [],
            ];
            $ids = [];
            $ids2 = [];
            if($item['category'] != null && $item['name'] != 'تبلیغ' && $item['name'] != 'تبلیغات اسلایدری'){
                $allCatSite3 = explode(',' , $item['category']);
                foreach ($allCatSite3 as $value){
                    $tax = Category::where('name' , $value)->first();
                    if($tax){
                        $send2 = $tax->post()->pluck('id')->toArray();
                        foreach ($send2 as $data){
                            array_push($ids ,$data);
                        }
                    }
                }
            }
            if($item['brand'] != '' && $item['name'] != 'تبلیغ' && $item['name'] != 'تبلیغات اسلایدری'){
                $allBrandSite3 = explode(',' , $item['brand']);
                foreach ($allBrandSite3 as $value){
                    $tax = Brand::where('name' , $value)->first();
                    if($tax){
                        $send2 = $tax->post()->pluck('id')->toArray();
                        foreach ($send2 as $data){
                            array_push($ids2 ,$data);
                        }
                    }
                }
            }
            if($item['category'] == ''){
                $ids = Post::pluck('id')->toArray();
            }
            if($item['brand'] == ''){
                $ids2 = Post::pluck('id')->toArray();
            }
            $arrayFilter = array_intersect($ids2, $ids);
            if ($item['show'] == 0){
                if($item['type'] == 3){
                    $catPost = Post::whereIn('id' , $arrayFilter)->latest()->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 0){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('count' , '>=' , 1)->latest()->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 1){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('off' , '!=' , null)->latest()->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 2){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('suggest' , '!=' , null)->latest()->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
            }
            if ($item['show'] == 1 or $item['show'] == 2){
                if($item['type'] == 3){
                    $catPost = Post::whereIn('id' , $arrayFilter)->withCount('view')->orderBy('view_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 0){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('count' , '>=' , 1)->withCount('view')->orderBy('view_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 1){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('off' , '!=' , null)->withCount('view')->orderBy('view_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 2){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('suggest' , '!=' , null)->withCount('view')->orderBy('view_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
            }
            if ($item['show'] == 3){
                if($item['type'] == 3){
                    $catPost = Post::whereIn('id' , $arrayFilter)->orderBy('price')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 0){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('count' , '>=' , 1)->orderBy('price')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 1){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('off' , '!=' , null)->orderBy('price')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 2){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('suggest' , '!=' , null)->orderBy('price')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
            }
            if ($item['show'] == 4){
                if($item['type'] == 3){
                    $catPost = Post::whereIn('id' , $arrayFilter)->orderBy('price','DESC')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 0){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('count' , '>=' , 1)->orderBy('price','DESC')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 1){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('off' , '!=' , null)->orderBy('price','DESC')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 2){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('suggest' , '!=' , null)->orderBy('price','DESC')->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
            }
            if ($item['show'] == 5){
                if($item['type'] == 3){
                    $catPost = Post::whereIn('id' , $arrayFilter)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 0){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('count' , '>=' , 1)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 1){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('off' , '!=' , null)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
                if($item['type'] == 2){
                    $catPost = Post::whereIn('id' , $arrayFilter)->where('suggest' , '!=' , null)->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->where('status' , 1)->take($item['count'])->with('postMeta','color','size')->get();
                }
            }
            $vidgetCategory['post'] = $catPost;

            if ($item['name'] == 'دسته بندی زیرمجموعه دار'){
                $vidgetCategory['post'] = [];
                $allCatSite3 = explode(',' , $item['category']);
                if ($item['show'] == 0){
                    if($item['type'] == 3){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->with('color')->latest();
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 0){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('count' , '>=' , 1)->with('color')->latest();
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 1){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('off' , '!=' , null)->with('color')->latest();
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 2){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('suggest' , '!=' , null)->with('color')->latest();
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                }
                if ($item['show'] == 1 or $item['show'] == 2){
                    if($item['type'] == 3){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->with('color')->withCount('view')->orderBy('view_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 0){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('count' , '>=' , 1)->with('color')->withCount('view')->orderBy('view_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 1){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('off' , '!=' , null)->with('color')->withCount('view')->orderBy('view_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 2){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('suggest' , '!=' , null)->with('color')->withCount('view')->orderBy('view_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                }
                if ($item['show'] == 3){
                    if($item['type'] == 3){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->with('color')->orderBy('price');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 0){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('count' , '>=' , 1)->with('color')->orderBy('price');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 1){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('off' , '!=' , null)->with('color')->orderBy('price');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 2){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('suggest' , '!=' , null)->with('color')->orderBy('price');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                }
                if ($item['show'] == 4){
                    if($item['type'] == 3){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->with('color')->orderBy('price','DESC');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 0){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('count' , '>=' , 1)->with('color')->orderBy('price','DESC');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 1){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('off' , '!=' , null)->with('color')->orderBy('price','DESC');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 2){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('suggest' , '!=' , null)->with('color')->orderBy('price','DESC');
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                }
                if ($item['show'] == 5){
                    if($item['type'] == 3){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->with('color')->withCount('payMeta')->orderBy('pay_meta_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 0){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('count' , '>=' , 1)->with('color')->withCount('payMeta')->orderBy('pay_meta_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 1){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('off' , '!=' , null)->with('color')->withCount('payMeta')->orderBy('pay_meta_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                    if($item['type'] == 2){
                        foreach ($allCatSite3 as $value){
                            $send = Category::where('name' , $value)->with(["cats" => function($q){
                                $q->take(4)->with(["post" => function($q){
                                    $q->where('status' , 1)->where('suggest' , '!=' , null)->with('color')->withCount('payMeta')->orderBy('pay_meta_count','DESC' );
                                }]);
                            }])->first();
                            $vidgetCategory['post'] = $send;
                        }
                    }
                }
            }

            if($item['name'] == 'برند های ویژه'){
                $vidgetCategory['post'] = [];
                $allCatSite3 = explode(',' , $item['brand']);
                $brands = Brand::whereIn('name',$allCatSite3)->latest()->get();
                $vidgetCategory['post'] = $brands;

            }
            if($item['name'] == 'دسته بندی ها'){
                $vidgetCategory['post'] = [];
                $allCatSite3 = explode(',' , $item['category']);
                $send = Category::whereIn('name',$allCatSite3)->latest()->with(["post" => function($q){
                    $q->where('status' , 1);
                }])->get();
                $vidgetCategory['post'] = $send;
            }
            if($item['name'] == 'تبلیغ'){
                $vidgetCategory['post'] = [];
                $vidgetCategory['post'] = $item['brand'];
            }
            if($item['name'] == 'تبلیغات اسلایدری'){
                $vidgetCategory['post'] = [];
                $vidgetCategory['title'] = [];
                $vidgetCategory['post'] = $item['brand'];
                $vidgetCategory['title'] = $item['category'];
            }
            if($item['name'] == 'پک'){
                $vidgetCategory['post'] = [];
                $packs = Pack::latest()->with('user')->with(["post" => function($q){
                    $q->where('status' , 1);
                }])->withCount('post')->take($item['count'])->get();
                $vidgetCategory['post'] = $packs;
            }
            if($item['name'] == 'خبر'){
                $vidgetCategory['post'] = [];
                $news = News::latest()->where('status' , 1)->with('user')->take($item['count'])->get();
                $vidgetCategory['post'] = $news;
            }
            array_push($vidget , $vidgetCategory);
        }
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        $moment = Post::inRandomOrder()->where('status' , 1)->where('count' , '>=' , 1)->where('off' , null)->take($showPostCategory)->get();
        $allColors = Color::latest()->get();
        $allCategories = Category::latest()->get();
        $allBrand = Brand::latest()->get();
        return Inertia::render('Home/Index/AllIndex',[
            'vidget' => $vidget,
            'allBrand' => $allBrand,
            'allColors' => $allColors,
            'allCategories' => $allCategories,
            'moment' => $moment,
            'title' => $title,
        ]);
    }
    public function getFilterCat(Request $request){
        $category = Category::where('id' , $request->category)->first();
        $showPostCategory = Setting::where('key' , 'showPostCategory')->pluck('value')->first();
        if ($request->filter == 0){
            $catPost = $category->post()->latest()->where('status' , 1)->with('color')->take($showPostCategory)->get();
        }
        if ($request->filter == 3){
            $catPost = $category->post()->withCount('payMeta')->orderBy('pay_meta_count','DESC' )->where('status' , 1)->with('color')->take($showPostCategory)->get();
        }
        if ($request->filter == 1 or $request->filter == 2){
            $catPost = $category->post()->withCount('view')->orderBy('view_count','DESC' )->where('status' , 1)->with('color')->take($showPostCategory)->get();
        }
        if ($request->filter == 4){
            $catPost = $category->post()->orderBy('price')->where('status' , 1)->with('color')->take($showPostCategory)->get();
        }
        if ($request->filter == 5){
            $catPost = $category->post()->orderBy('price','DESC')->where('status' , 1)->with('color')->take($showPostCategory)->get();
        }
        return $catPost;
    }
    public function getSuggest(Request $request){
        return $showSuggest = Post::where('id' , $request->postSuggestId)->where('count' , '>=' , 1)->with('postMeta','color','size')->first();
    }
    public function showCompares(Request $request){
        $postsItem =[];
        foreach ($request->postCompare as $posts) {
            $send = Post::where('id' , $posts['id'])->with('postMeta','color')->first();
            array_push($postsItem ,$send);
        }
        return $postsItem;
    }
    public function showFast(Request $request){
        return Post::where('id' , $request->postId)->with('postMeta','category','brand','color','size')->first();
    }
}
