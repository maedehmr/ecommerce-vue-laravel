<?php

namespace App\Actions\Fortify;

use App\Models\Cart;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        $myCart = request()->cookie('myCart');
        $myCookieCart = json_decode($myCart , true);
        if($myCookieCart){
            if($myCart){
                for ($i = 0; $i < count(json_decode($myCart , true)); $i++) {
                    foreach($user->cart as $value) {
                        if (json_decode($myCart , true)[$i]['id'] == $value->post_id && $value->size == json_decode($myCart , true)[$i]['size'] && $value->color == json_decode($myCart , true)[$i]['color']) {
                            $myCookieCart[$i]['id'] = 0;
                        }
                    }
                }
                foreach($myCookieCart as $value) {
                    if($value['id'] != 0){
                        Cart::create([
                            'post_id' => $value['id'],
                            'user_id' => $user->id,
                            'color' => $value['color'],
                            'size' => $value['size'],
                            'count' => $value['count'],
                        ]);
                    }
                }
            }
        }
        return $user;
    }
}
