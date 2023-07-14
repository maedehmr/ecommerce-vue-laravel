<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

class PackController extends Controller
{
    public function index(Request $request){
        $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش پک')->pluck('name');
        $checkEdits =  auth()->user()->getAllPermissions()->where('name' , 'ویرایش پک')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف پک')->pluck('name');
        $checkAdds =  auth()->user()->getAllPermissions()->where('name' , 'افزودن پک')->pluck('name');
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
        if(auth()->user()->admin == 1 or count($checkAdds) >= 1){
            $adds = 1;
        }else{
            $adds = 0;
        }
        if(auth()->user()->admin == 1 or count($showSome) >= 1){
            $shows = 1;
        }else{
            $shows = 0;
        }

        if($request->value){
            foreach ($request->value as $value) {
                $tax = Pack::where('id', $value)->first();
                $tax->user()->detach();
                $tax->post()->detach();
            }
            DB::table('packs')->whereIn('id', $request->value)->delete();
        }
        if($request->title){
            $request->validate([
                'title' => 'required|max:220',
                'image' => 'required|max:255',
                'price' => 'required|max:255',
                'count' => 'required|max:11',
            ]);
            if($request->taxId){
                $tax = Pack::where('id' , $request->taxId)->first();
                $tax->update([
                    'title'=> $request->title,
                    'count'=> $request->count,
                    'image'=> $request->image,
                    'price'=> $request->price,
                    'slug'=> $request->slug,
                    'updated_at'=> Carbon::now(),
                ]);
                $tax->post()->detach();
                $tax->post()->sync($request->allPostId);
            }else{
                $tax = Pack::where('title' , $request->title)->first();
                if (!$tax){
                    $tax = Pack::create([
                        'title'=> $request->title,
                        'price'=> $request->price,
                        'count'=> $request->count,
                        'image'=> $request->image,
                        'slug'=> $request->slug,
                    ]);
                    auth()->user()->pack()->sync($tax->id);
                    $tax->post()->sync($request->allPostId);
                }
            }
        }
        if($request->taxId && !$request->title){
            $packEdit = Pack::where('id' , $request->taxId)->with('post')->first();
        }else{
            $packEdit = '';
        }


        if ($request->search){
            if (count($showSome) >= 1){
                $search = auth()->user()->pack()->where("name" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                if(count($search) == 0){
                    $search = auth()->user()->pack()->where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                }
            }else{
                $search = Pack::where("name" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                if(count($search) == 0){
                    $search = Pack::where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                }
            }
        }else{
            if(count($showSome) >= 1){
                $search = auth()->user()->pack()->pluck('id')->toArray();
            }else{
                $search = Pack::latest()->pluck('id')->toArray();
            }
        }
        if ($request->date){
            if (count($showSome) >= 1){
                $date = auth()->user()->pack()->whereDate('created_at',$request->date)->pluck('id')->toArray();
            }else{
                $date = Pack::whereDate('created_at',$request->date)->pluck('id')->toArray();
            }
        }else{
            if(count($showSome) >= 1){
                $date = auth()->user()->pack()->pluck('id')->toArray();
            }else{
                $date = Pack::latest()->pluck('id')->toArray();
            }
        }

        $arrayFilter = array_intersect($search,$date);
        $packs = Pack::latest()->whereIn('id' , $arrayFilter)->paginate(30);
        $posts = Post::latest()->get();
        $labels = ['#','آیدی','عنوان','مبلغ','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Pack/PackPanel' , [
            'packs' => $packs,
            'posts' => $posts,
            'adds' => $adds,
            'labels' => $labels,
            'edits' => $edits,
            'deletes' => $deletes,
            'shows' => $shows,
            'packEdit' => $packEdit,
        ]);
    }
}
