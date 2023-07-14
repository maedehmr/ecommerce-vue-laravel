<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request){
        $checkEdits =  auth()->user()->getAllPermissions()->where('name' , 'ویرایش برگه')->pluck('name');
        $checkShows =  auth()->user()->getAllPermissions()->where('name' , 'نمایش برگه')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف برگه')->pluck('name');
        $checkAdds =  auth()->user()->getAllPermissions()->where('name' , 'افزودن برگه')->pluck('name');
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
        if(auth()->user()->admin == 1 or count($checkShows) >= 1){
            $shows = 1;
        }else{
            $shows = 0;
        }

        if($request->value){
            DB::table('pages')->whereIn('id', $request->value)->delete();
        }
        if($request->name){
            $request->validate([
                'name' => 'required|max:220',
            ]);
            if($request->taxId){
                $tax = Page::where('id' , $request->taxId)->first();
                $tax->update([
                    'title'=> $request->name,
                    'slug'=> $request->slug,
                    'body'=> $request->body,
                    'updated_at'=> Carbon::now(),
                ]);
            }else{
                $tax = Page::where('title' , $request->name)->first();
                if (!$tax){
                    $tax = Page::create([
                        'title'=> $request->name,
                        'slug'=> $request->slug,
                        'body'=> $request->body,
                    ]);
                }
            }
        }
        if($request->taxId && !$request->name){
            $taxEdit = Page::where('id' , $request->taxId)->first();
        }else{
            $taxEdit = '';
        }
        
        if ($request->search){
            $search = Page::where("title" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();  
            if(count($search) == 0){
                $search = Page::where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
            }          
        }else{
            $search = Page::latest()->pluck('id')->toArray();
        }
        if ($request->date){
            $date = Page::whereDate('created_at',$request->date)->pluck('id')->toArray();            
        }else{
            $date = Page::latest()->pluck('id')->toArray();
        }

        $arrayFilter = array_intersect($search,$date);
        $taxes = Page::latest()->whereIn('id' , $arrayFilter)->paginate(30);
        $name='برگه';
        $routeAddress='page';
        $sidebar= ['0','20'];
        $labels = ['#','آیدی','عنوان','پیوند','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Taxonami/AllTaxonami' , [
            'name' => $name,
            'labels' => $labels,
            'adds' => $adds,
            'shows' => $shows,
            'edits' => $edits,
            'deletes' => $deletes,
            'taxes' => $taxes,
            'taxEdit' => $taxEdit,
            'sidebar' => $sidebar,
            'routeAddress' => $routeAddress,
        ]);
    }
}
