<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Services\SocialFacebookAccountService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use Validator;
use Auth;
use Exception;


class SocialAuthFacebookController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback()
    {

        try {
    
            $user = Socialite::driver('facebook')->stateless()->user();

            var_dump($user->id);

            $finduser = User::where('facebook_id', $user->id)->first();
            
            dd($finduser);

            if(!empty($finduser)){

                Auth::login($finduser);
                
                return redirect('/home');
     
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'facebook_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
    
                Auth::login($newUser);
     
                return redirect('/home');
            }
    
        } catch (Exception $e) {
            dd($e);
        }
    }
}
