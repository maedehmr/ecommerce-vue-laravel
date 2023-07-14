<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Color;

class ColorController extends Controller
{
    public function index(Request $request){
        $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش رنگ های خودش')->pluck('name');
        $showSome2 =  auth()->user()->getAllPermissions()->where('name' , 'نمایش همه رنگ ها')->pluck('name');
        $checkEdits =  auth()->user()->getAllPermissions()->where('name' , 'ویرایش رنگ')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف رنگ')->pluck('name');
        $checkAdds =  auth()->user()->getAllPermissions()->where('name' , 'افزودن رنگ')->pluck('name');
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
        if(auth()->user()->admin == 1 or count($showSome) >= 1 or count($showSome2) >= 1){
            $shows = 1;
        }else{
            $shows = 0;
        }

        if($request->value){
            foreach ($request->value as $value) {
                $tax = Color::where('id', $value)->first();
                $tax->user()->detach();
                $tax->post()->detach();
            }
            DB::table('colors')->whereIn('id', $request->value)->delete();
        }
        if($request->name){
            $request->validate([
                'name' => 'required|max:220',
                'code' => 'required|max:220',
            ]);
            if($request->taxId){
                $tax = Color::where('id' , $request->taxId)->first();
                $tax->update([
                    'name'=> $request->name,
                    'code'=> $request->code,
                    'updated_at'=> Carbon::now(),
                ]);
            }else{
                $tax = Color::where('name' , $request->name)->first();
                if (!$tax){
                    $tax = Color::create([
                        'name'=> $request->name,
                    'code'=> $request->code,
                    ]);
                    auth()->user()->color()->sync($tax->id);
                }
            }
        }
        if($request->taxId && !$request->name){
            $taxEdit = Color::where('id' , $request->taxId)->first();
        }else{
            $taxEdit = '';
        }
        
        
        if ($request->search){
            if (count($showSome) >= 1){
                $search = auth()->user()->color()->where("name" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                if(count($search) == 0){
                    $search = auth()->user()->color()->where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                }
            }else{
                $search = Color::where("name" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                if(count($search) == 0){
                    $search = Color::where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
                }
            }
        }else{
            if(count($showSome) >= 1){
                $search = auth()->user()->color()->pluck('id')->toArray();
            }else{
                $search = Color::latest()->pluck('id')->toArray();
            }
        }
        if ($request->date){
            if (count($showSome) >= 1){
                $date = auth()->user()->color()->whereDate('created_at',$request->date)->pluck('id')->toArray();
            }else{
                $date = Color::whereDate('created_at',$request->date)->pluck('id')->toArray();
            }
        }else{
            if(count($showSome) >= 1){
                $date = auth()->user()->color()->pluck('id')->toArray();
            }else{
                $date = Color::latest()->pluck('id')->toArray();
            }
        }

        $arrayFilter = array_intersect($search,$date);
        $taxes = Color::latest()->whereIn('id' , $arrayFilter)->paginate(30);
        $name='رنگ';
        $routeAddress='color';
        $sidebar= ['4','15'];
        $labels = ['#','آیدی','نام','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Taxonami/AllTaxonami' , [
            'name' => $name,
            'taxes' => $taxes,
            'adds' => $adds,
            'labels' => $labels,
            'edits' => $edits,
            'deletes' => $deletes,
            'shows' => $shows,
            'taxEdit' => $taxEdit,
            'routeAddress' => $routeAddress,
            'sidebar' => $sidebar,
        ]);
    }
}
