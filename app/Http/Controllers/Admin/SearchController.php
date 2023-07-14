<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Size;

class SearchController extends Controller
{
    public function tax(Request $request){
        if($request->taxRoute == 'دسته بندی'){
            $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش دسته های خودش')->pluck('name');
            if(count($showSome) >= 1){
                $search = auth()->user()->category()->where("name" , "LIKE" , "%{$request->search}%")->pluck('name','id')->toArray();
            }else{
                return Category::where("name" , "LIKE" , "%{$request->search}%")->pluck('name' , 'id');
            }
        }
        if($request->taxRoute == 'رنگ'){
            $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش رنگ های خودش')->pluck('name');
            if(count($showSome) >= 1){
                $search = auth()->user()->color()->where("name" , "LIKE" , "%{$request->search}%")->pluck('name','id')->toArray();
            }else{
                return Cclor::where("name" , "LIKE" , "%{$request->search}%")->pluck('name' , 'id');
            }
        }
        if($request->taxRoute == 'برند'){
            $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش برند های خودش')->pluck('name');
            if(count($showSome) >= 1){
                $search = auth()->user()->brand()->where("name" , "LIKE" , "%{$request->search}%")->pluck('name','id')->toArray();
            }else{
                return Brand::where("name" , "LIKE" , "%{$request->search}%")->pluck('name' , 'id');
            }
        }
        if($request->taxRoute == 'سایز'){
            $showSome =  auth()->user()->getAllPermissions()->where('name' , 'نمایش سایز های خودش')->pluck('name');
            if(count($showSome) >= 1){
                $search = auth()->user()->size()->where("name" , "LIKE" , "%{$request->search}%")->pluck('name','id')->toArray();
            }else{
                return Size::where("name" , "LIKE" , "%{$request->search}%")->pluck('name' , 'id');
            }
        }
    }
    public function taxCreate(Request $request){
        if($request->taxRoute == 'برند'){
            $tax = Brand::where('name' , $request->tax)->first();
            if (!$tax){
                $tax = Brand::create([
                    'name'=> $request->tax,
                ]);
                auth()->user()->brand()->sync($tax->id);
                return $tax;
            }else{
                return 'exist';
            }
        }
        if($request->taxRoute == 'سایز'){
            $tax = Size::where('name' , $request->tax)->first();
            if (!$tax){
                $tax = Size::create([
                    'name'=> $request->tax,
                ]);
                auth()->user()->size()->sync($tax->id);
                return $tax;
            }else{
                return 'exist';
            }
        }
        if($request->taxRoute == 'رنگ'){
            $tax = Color::where('name' , $request->tax)->first();
            if (!$tax){
                $tax = Color::create([
                    'name'=> $request->tax,
                ]);
                auth()->user()->color()->sync($tax->id);
                return $tax;
            }else{
                return 'exist';
            }
        }
        if($request->taxRoute == 'دسته بندی'){
            $tax = Category::where('name' , $request->tax)->first();
            if (!$tax){
                $tax = Category::create([
                    'name'=> $request->tax,
                ]);
                auth()->user()->category()->sync($tax->id);
                return $tax;
            }else{
                return 'exist';
            }
        }
    }
}
