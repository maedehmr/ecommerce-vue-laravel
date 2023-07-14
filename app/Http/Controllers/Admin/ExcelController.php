<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PayExport;
use App\Exports\PostExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index(Request $request){
        return Inertia::render('Admin/Excel/ExcelPanel');
    }
    public function getExcel($data){
        if($data == 'allUser'){
            return Excel::download(new UsersExport('allUser'), 'users.xlsx');
        }
        if($data == 'todayUser'){
            return Excel::download(new UsersExport('todayUser'), 'todayUsers.xlsx');
        }
        if($data == 'allPay'){
            return Excel::download(new PayExport('allPay'), 'pays.xlsx');
        }
        if($data == 'todayPay'){
            return Excel::download(new PayExport('todayPay'), 'todayPays.xlsx');
        }
        if($data == 'allProduct'){
            return Excel::download(new PostExport('allProduct'), 'products.xlsx');
        }
        if($data == 'todayProduct'){
            return Excel::download(new PostExport('todayProduct'), 'todayProducts.xlsx');
        }
    }
}
