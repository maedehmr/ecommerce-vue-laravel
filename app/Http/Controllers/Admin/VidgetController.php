<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Vidget;
use App\Models\Brand;
use App\Models\Category;

class VidgetController extends Controller
{
    public function template(Request $request){
        if($request->update){
            DB::table('vidgets')->delete();
            foreach ($request->allSiteTemplate as $item){
                if($item['brand'] != '' && $item['name'] != 'تبلیغ' && $item['name'] != 'تبلیغات اسلایدری'){
                    $brand = implode(',' , $item['brand']);
                }else{
                    $brand = '';
                }
                if($item['category'] != '' && $item['name'] != 'تبلیغ' && $item['name'] != 'تبلیغات اسلایدری'){
                    $category = implode(',' , $item['category']);
                }else{
                    $category = '';
                }
                if($item['name'] == 'تبلیغ'){
                    Vidget::create([
                        'name'=> $item['name'],
                        'brand'=> $item['brand'],
                        'more'=> $item['more'],
                        'show'=> $item['show'],
                        'type'=> $item['type'],
                        'count'=> $item['count'],
                        'slug'=> $item['slug'],
                        'title'=> $item['title'],
                    ]);
                }
                elseif ($item['name'] == 'تبلیغات اسلایدری'){
                    Vidget::create([
                        'name'=> $item['name'],
                        'brand'=> $item['brand'],
                        'category'=> $item['category'],
                        'more'=> $item['more'],
                        'show'=> $item['show'],
                        'type'=> $item['type'],
                        'slug'=> 'تبلیغات اسلایدری',
                        'title'=> 'تبلیغات اسلایدری',
                    ]);
                }
                else{
                    Vidget::create([
                        'name'=> $item['name'],
                        'title'=> $item['title'],
                        'more'=> $item['more'],
                        'show'=> $item['show'],
                        'type'=> $item['type'],
                        'background'=> $item['background'],
                        'count'=> $item['count'],
                        'slug'=> $item['slug'],
                        'category'=> $category,
                        'brand'=> $brand,
                    ]);
                }
            }
        }
        $category = Category::latest()->get();
        $brand = Brand::latest()->get();
        $vidgets = Vidget::get();
        $vidget = [];
        foreach ($vidgets as $item){
            $vidgetCategory = [
                'name'=> $item['name'],
                'title'=> $item['title'],
                'more'=> $item['more'],
                'show'=> $item['show'],
                'type'=> $item['type'],
                'count'=> $item['count'],
                'background'=> $item['background'],
                'slug'=> $item['slug'],
                'category'=> [],
                'brand'=> [],
            ];
            if($item['brand'] != null){
                $vidgetCategory['brand'] = explode(',' , $item['brand']);
            }else{
                $vidgetCategory['brand'] = [];
            }
            if($item['category'] != null){
                $vidgetCategory['category'] = explode(',' , $item['category']);
            }else{
                $vidgetCategory['category'] = [];
            }
            array_push($vidget , $vidgetCategory);
        }
        return Inertia::render('Admin/Setting/TemplateSetting',[
            'vidget' => $vidget,
            'category' => $category,
            'brand' => $brand,
        ]);
    }
}
