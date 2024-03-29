<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function githHub() {
        return Socialite::driver('github')->redirect();

    }

    public function githHubUser(){
        $gitHubInfo = Socialite::driver('github')->user();
        $check = User::where('githhub_id', $gitHubInfo->id)->orWhere('email', $gitHubInfo->email)->get()->first();
        if($check) {
            auth()->login($check);
        }else{
            $user = User::create([
                'name' => $gitHubInfo->nickname,
                'email' => $gitHubInfo->email,
                'githhub_id' => $gitHubInfo->id,
            ]);
            auth()->login($user);
        }
        return redirect('/home');
    }


}
