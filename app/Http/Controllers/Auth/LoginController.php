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
     * Sign up view only shown if it comes via Login for Twitter first time.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signupAccount()
    {
        if(!session('twitter')) {
            return redirect('/login');
        }
        return view('auth.signup');
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
        session(['twitter' => $user]);
        return redirect('/auth/signup');
    }


    /**
     * Redirect to  Bitly
     * @return mixed
     */
    public function bitlyRedirect()
    {
        return Socialite::with('bitly')->redirect();
    }

    /**
     *  Bitly Callback
     */
    public function bitlyCallback()
    {
        $user = Socialite::with('bitly')->user();
        dd($user);
    }
}
