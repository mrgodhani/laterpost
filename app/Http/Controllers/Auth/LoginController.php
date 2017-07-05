<?php

namespace Laterpost\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use Laterpost\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/app';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect to Twitter
     * @return mixed
     */
    public function twitterRedirect()
    {
        return Socialite::driver('twitter')->redirect();
    }

    /**
     *  Twitter Callback
     */
    public function twitterCallback()
    {
        $user = Socialite::driver('twitter')->user();
        dd($user);
    }


    public function bitlyRedirect()
    {

    }
}
