<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index(Request $request){
        $checkEdits =  auth()->user()->getAllPermissions()->where('name' , 'ویرایش مقام')->pluck('name');
        $checkDeletes =  auth()->user()->getAllPermissions()->where('name' , 'حذف مقام')->pluck('name');
        $checkAdds =  auth()->user()->getAllPermissions()->where('name' , 'افزودن مقام')->pluck('name');
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
        if($request->value){
            foreach ($request->value as $value) {
                $tax = Role::where('id', $value)->first();
                foreach ($tax->permissions as $permission) {
                    $tax->revokePermissionTo($permission);
                }
            }
            DB::table('roles')->whereIn('id', $request->value)->delete();
        }
        if($request->name){
            $request->validate([
                'name' => 'required|max:255',
            ]);
            if($request->roleId){
                $role = Role::where('id' , $request->roleId)->first();
                $role->update([
                    'name'=> $request->name,
                    'updated_at'=> Carbon::now(),
                ]);
                foreach ($role->permissions as $permission) {
                    $role->revokePermissionTo($permission);
                }
                foreach ($request->permission as $permission) {
                    $role->givePermissionTo($permission);
                }
            }else{
                $role = Role::where('name' , $request->name)->first();
                if (!$role){
                    $role = Role::create([
                        'name'=> $request->name,
                    ]);
                    foreach ($request->permission as $permission) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
        if($request->roleId && !$request->name){
            $roleEdit = Role::where('id' , $request->roleId)->with('permissions')->first();
        }else{
            $roleEdit = '';
        }
        if ($request->search){
            $search = Role::where("name" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
            if(count($search) == 0){
                $search = Role::where("id" , "LIKE" , "%{$request->search}%")->pluck('id')->toArray();
            }          
        }else{
            $search = Role::latest()->pluck('id')->toArray();
        }
        if ($request->date){
            $date = Role::whereDate('created_at',$request->date)->pluck('id')->toArray();            
        }else{
            $date = Role::latest()->pluck('id')->toArray();
        }
        $arrayFilter = array_intersect($search,$date);
        $roles = Role::latest()->whereIn('id' , $arrayFilter)->paginate(30);
        
        $permissions = Permission::latest()->get();
        $labels = ['#','آیدی','نام','تاریخ ثبت','عملیات'];
        return Inertia::render('Admin/Role/RolePanel' , [
            'labels' => $labels,
            'adds' => $adds,
            'edits' => $edits,
            'deletes' => $deletes,
            'roleEdit' => $roleEdit,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }
}
