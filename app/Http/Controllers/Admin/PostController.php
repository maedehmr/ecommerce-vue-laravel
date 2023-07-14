<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Time;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Gallery;
use Intervention\Image\Facades\Image;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use App\Models\PostMeta;
use App\Models\User;
use App\Models\PayMeta;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request){
        $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش پست های خودش')->pluck('name');
        $showSome2 =  auth()->user()->getAllPermissions()->where('name' , 'نمایش همه پست ها')->pluck('name');
        $checkEdits =  auth()->user()->getAllPermissions()->where('name' , 'ویرایش پست')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف پست')->pluck('name');
        if(auth()->user()->admin == 1 or count($checkEdits) >= 1){
            $edits = 1;
        }else{
            $edits = 0;
        }
        if(auth()->user()->admin == 1 or count($checkDeletes) >= 1){
            $deletes = 1;
        }else{
            $deletes = 0;
        }
        if(auth()->user()->admin == 1 or count($showSome) >= 1 or count($showSome2) >= 1){
            $shows = 1;
        }else{
            $shows = 0;
        }

        if($request->value){
            foreach ($request->value as $value) {
                $post = Post::where('id', $value)->first();
                $post->category()->detach();
                $post->bookmark()->delete();
                $post->comments()->delete();
                $post->like()->delete();
                $post->rate()->delete();
                $post->brand()->detach();
                $post->size()->detach();
                $post->color()->detach();
                $post->time()->detach();
                $post->payMeta()->delete();
                $post->cart()->delete();
                $post->postMeta()->detach();
                PostMeta::where('id' , $post->postMeta()->pluck('id')->first())->delete();
            }
            DB::table('posts')->whereIn('id', $request->value)->delete();
        }

        if($request->postShow){
            $showPosts = Post::where('id',$request->postShow)->with('color' ,'user' , 'size' , 'postMeta')->withCount('comments','view')->first();
        }else{
            $showPosts = [];
        }

        if($request->postId){
            $request->validate([
                'title' => 'required|max:220',
                'image' => 'required',
            ]);
            $post = Post::where('id' , $request->postId)->first();
            if ($request->off){
                $price = round($request->price - $request->price * $request->off / 100);
            }else{
                $price = $request->price;
            }
            $post->update([
                'summery'=>$request->summery,
                'title'=>$request->title,
                'count'=>$request->count,
                'image'=>$request->image,
                'status'=>$request->status,
                'slug'=>$request->slug,
                'price'=>$price,
                'offPrice'=>$request->price,
                'off'=>$request->off,
                'suggest'=>$request->suggest,
            ]);
            $post->postMeta()->first()->update([
                'body'=>$request->body,
                'titleEn'=>$request->titleEn,
                'guarantee'=>$request->guarantee,
            ]);
        }

        if($request->postEdit){
            $getPost = Post::where('id' , $request->postEdit)->with('postMeta')->first();
        }else{
            $getPost = '';
        }
        if ($request->getPage){
            $page = $request->getPage;
        }else{
            $page = '25';
        }

        if ($request->category){
            if (count($showSome) >= 1){
                $categoryName = auth()->user()->category()->latest()->where('name' , $request->category)->first();
                $category = $categoryName->post()->pluck('id')->toArray();
            }else{
                $categoryName = Category::latest()->where('name' , $request->category)->first();
                $category = $categoryName->post()->pluck('id')->toArray();
            }
        }else{
            if (count($showSome) >= 1){
                $category = auth()->user()->post()->latest()->pluck('id')->toArray();
            }else{
                $category = Post::latest()->pluck('id')->toArray();
            }
        }

        $categories = Category::latest()->get();
        if ($request->sort == 1){
            if ($request->search){
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '0')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '0')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->where('status' , '0')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->where('status' , '0')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '0')->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '0')->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->where('status' , '0')->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->where('status' , '0')->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }
            }else{
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereDate('created_at',$request->date)->whereIn('id',$category)->where('status' , '0')->paginate($page);
                    }else{
                        $posts = Post::latest()->whereDate('created_at',$request->date)->whereIn('id',$category)->where('status' , '0')->paginate($page);
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '0')->whereIn('id',$category)->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '0')->whereIn('id',$category)->paginate($page);
                    }
                }
            }
        }elseif($request->sort == 2){
            if ($request->search){
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '1')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '1')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->where('status' , '1')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->where('status' , '1')->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '1')->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '1')->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->where('status' , '1')->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->where('status' , '1')->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }
            }else{
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereDate('created_at',$request->date)->whereIn('id',$category)->where('status' , '1')->paginate($page);
                    }else{
                        $posts = Post::latest()->whereDate('created_at',$request->date)->whereIn('id',$category)->where('status' , '1')->paginate($page);
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->where('status' , '1')->whereIn('id',$category)->paginate($page);
                    }else{
                        $posts = Post::latest()->where('status' , '1')->whereIn('id',$category)->paginate($page);
                    }
                }
            }
        }else{
            if ($request->search){
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->whereIn('id',$category)->whereDate('created_at',$request->date)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->whereIn('id',$category)->whereDate('created_at',$request->date)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }else{
                        $posts = Post::latest()->whereIn('id',$category)->where("title" , "LIKE" , "%{$request->search}%")->paginate($page);
                    }
                    if (count($posts) == 0){
                        if (count($showSome) >= 1){
                            $posts = auth()->user()->post()->latest()->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }else{
                            $posts = Post::latest()->whereIn('id',$category)->where("id" , "LIKE" , "%{$request->search}%")->paginate($page);
                        }
                    }
                }
            }else{
                if ($request->date){
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereIn('id',$category)->whereDate('created_at',$request->date)->paginate($page);
                    }else{
                        $posts = Post::latest()->whereIn('id', $category)->whereDate('created_at',$request->date)->paginate($page);
                    }
                }else{
                    if (count($showSome) >= 1){
                        $posts = auth()->user()->post()->latest()->whereIn('id', $category)->paginate($page);
                    }else{
                        $posts = Post::latest()->whereIn('id',$category)->paginate($page);
                    }
                }
            }
        }
        $labels = ['آیدی','تصویر','عنوان','وضعیت','مبلغ','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Post/AllPost' , [
            'labels' => $labels,
            'posts' => $posts,
            'getPost' => $getPost,
            'showPosts' => $showPosts,
            'edits' => $edits,
            'deletes' => $deletes,
            'shows' => $shows,
            'categories' => $categories,
        ]);
    }

    public function create(Request $request){
        if($request->title or $request->image or $request->body or $request->summery){
            $request->validate([
                'title' => 'required|max:220',
                'images' => 'required',
                'status' => 'required',
                'count' => 'required',
                'price' => 'required',
            ]);
            if ($request->off){
                $price = round($request->price - $request->price * $request->off / 100);
            }else{
                $price = $request->price;
            }
            $id = Setting::where('key' , 'productId')->pluck('value')->first();
            $productIds = count(Post::get()) +2000;
            $post = Post::create([
                'summery'=>$request->summery,
                'count'=>$request->count,
                'title'=>$request->title,
                'status'=>$request->status,
                'slug'=>$request->slug,
                'image'=>$request->image,
                'price'=>$price,
                'offPrice'=>$request->price,
                'off'=>$request->off,
                'used'=>$request->used,
                'original'=>$request->original,
                'showcase'=>$request->showcase,
                'suggest'=>$request->suggest,
                'user_id'=>auth()->user()->id,
                'code'=> $id . '-' .  $productIds,
            ]);
            $meta = PostMeta::create([
                'body'=>$request->body,
                'guarantee'=>$request->guarantee,
                'titleEn'=>$request->titleEn,
                'rate'=> $request->allRate,
                'ability'=>$request->allAbility,
                'property'=>$request->allProperty,
            ]);
            $post->postMeta()->sync($meta->id);
            $post->category()->sync($request->allCategory);
            $post->brand()->sync($request->allBrand);
            $post->size()->sync($request->allSize);
            $post->color()->sync($request->allColor);
            $post->time()->sync($request->allTime);
        }
        $categories = Category::latest()->pluck('name' , 'id');
        $brands = Brand::latest()->pluck('name' , 'id');
        $sizes = Size::latest()->pluck('name' , 'id');
        $colors = Color::latest()->pluck('name' , 'id');
        $times = Time::latest()->pluck('name' , 'id');
        $sidebar= ['2','5'];
        return Inertia::render('Admin/Post/CreatePost' , [
            'categories' => $categories,
            'brands' => $brands,
            'times' => $times,
            'sidebar' => $sidebar,
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }

    public function edit(Request $request, Post $post){
        if($request->title or $request->image or $request->body or $request->summery){
            $request->validate([
                'title' => 'required|max:220',
                'images' => 'required',
                'status' => 'required',
                'count' => 'required',
                'price' => 'required',
            ]);
            if ($request->off){
                $price = round($request->price - $request->price * $request->off / 100);
            }else{
                $price = $request->price;
            }
            $post->update([
                'summery'=>$request->summery,
                'count'=>$request->count,
                'title'=>$request->title,
                'status'=>$request->status,
                'slug'=>$request->slug,
                'image'=>$request->image,
                'price'=>$price,
                'offPrice'=>$request->price,
                'used'=>$request->used,
                'original'=>$request->original,
                'off'=>$request->off,
                'suggest'=>$request->suggest,
                'showcase'=>$request->showcase,
                'updated_at'=>Carbon::now(),
            ]);
            $post->postMeta()->first()->update([
                'body'=>$request->body,
                'guarantee'=>$request->guarantee,
                'rate'=> $request->allRate,
                'ability'=>$request->allAbility,
                'property'=>$request->allProperty,
            ]);
            $post->color()->detach();
            $post->size()->detach();
            $post->category()->detach();
            $post->brand()->detach();
            $post->time()->detach();
            $post->size()->sync($request->allSize);
            $post->color()->sync($request->allColor);
            $post->category()->sync($request->allCategory);
            $post->brand()->sync($request->allBrand);
            $post->time()->sync($request->allTime);
        }
        $category = $post->category;
        $brand = $post->brand;
        $color = $post->color;
        $size = $post->size;
        $time = $post->time;
        $categories = Category::latest()->pluck('name' , 'id');
        $brands = Brand::latest()->pluck('name' , 'id');
        $colors = Color::latest()->pluck('name' , 'id');
        $sizes = Size::latest()->pluck('name' , 'id');
        $times = Time::latest()->pluck('name' , 'id');
        $posts = Post::where('id' , $post->id)->with('postMeta')->first();
        return Inertia::render('Admin/Post/EditPost' , [
            'posts' => $posts,
            'categories' => $categories,
            'brands' => $brands,
            'times' => $times,
            'time' => $time,
            'colors' => $colors,
            'sizes' => $sizes,
            'category' => $category,
            'size' => $size,
            'color' => $color,
            'brand' => $brand,
        ]);
    }

    public function show(Post $post)
    {
        $payMeta = PayMeta::where('post_id' , $post->id)->with('user','pay')->paginate(20);
        $reply = Setting::where('key' , 'replyComment')->pluck('value')->first();
        $coercion = Setting::where('key' , 'coercionComment')->pluck('value')->first();
        $showUser = Setting::where('key' , 'showUserComment')->pluck('value')->first();
        $checkOnline = Setting::where('key' , 'checkOnlineComment')->pluck('value')->first();
        $posts = Post::where('id',$post->id)->with('postMeta' , 'user')->withCount('bookmark' , 'payMeta' , 'like' , 'view' , 'comments')->first();
        return Inertia::render('Admin/Post/ShowPost' , [
            'payMeta' => $payMeta,
            'posts' => $posts,
            'reply' => $reply,
            'coercion' => $coercion,
            'showUser' => $showUser,
            'checkOnline' => $checkOnline,
        ]);
    }
    public function digikala(Request $request){
        $ch = curl_init('https://api.digikala.com/v1/product/'.$request->digikala.'/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result, true, JSON_PRETTY_PRINT);
        curl_close($ch);

        $images = [];
        $categories = [];
        $brands = [];
        foreach($result['data']['product']['images']['list'] as $item){
            $year = Carbon::now()->year;
            $time = time();
            $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
            $url = '/upload/image/' . $year . '/';
            $img = Image::make($item['url'][0])->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
            $sizefile = $img->filesize() / 1000;
            if ($sizefile > 1000) {
                $size = round($sizefile / 1000, 2) . 'mb';
            } else {
                $size = round($sizefile) . 'kb';
            }
            $image = Gallery::create([
                'name' => $time . '.' . 'jpg',
                'size' => $size,
                'type' => 'jpg',
                'user_id' => auth()->user()->id,
                'url' => $url . $time . '.' . 'jpg',
                'path' => $path . $time . '.' . 'jpg',
            ]);
            array_push($images , $image['url']);
            sleep(1);
        }
        if($result['data']['product']['brand']){
            $brand1 = Brand::where('name' , $result['data']['product']['brand']['title_fa'])->first();
            if($brand1){
                $brand = $brand1;
            }else{
                $year = Carbon::now()->year;
                $time = time();
                $path = $_SERVER['DOCUMENT_ROOT'] . '/upload/image/' . $year . '/';
                $url = '/upload/image/' . $year . '/';
                $img = Image::make($result['data']['product']['brand']['logo']['url'][0])->save('upload/image/' . $year . '/' . $time . '.' . 'jpg', 100, 'jpg');
                $sizefile = $img->filesize() / 1000;
                if ($sizefile > 1000) {
                    $size = round($sizefile / 1000, 2) . 'mb';
                } else {
                    $size = round($sizefile) . 'kb';
                }
                $imagePost = Gallery::create([
                    'name' => $time . '.' . 'jpg',
                    'size' => $size,
                    'type' => 'jpg',
                    'user_id' => auth()->user()->id,
                    'url' => $url . $time . '.' . 'jpg',
                    'path' => $path . $time . '.' . 'jpg',
                ]);
                $brand = Brand::create([
                    'name' => $result['data']['product']['brand']['title_fa'],
                ]);
            }
            array_push($brands , $brand);
        }
        if($result['data']['product']['category']){
            $category1 = Category::where('name' , $result['data']['product']['category']['title_fa'])->first();
            if($category1){
                $category = $category1;
            }else{
                $category = Category::create([
                    'name' => $result['data']['product']['category']['title_fa'],
                ]);
            }
            array_push($categories , $category);
        }
        $price = substr($result['data']['product']['default_variant']['price']['selling_price'], 0, -1);;
        return [$result['data'],$brands,$categories,$price,$images];
    }
}
