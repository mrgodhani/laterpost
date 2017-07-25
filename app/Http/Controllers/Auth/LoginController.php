<?php

namespace Laterpost\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laterpost\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laterpost\Services\AccountService;

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
     * @var AccountService
     */
    private $accountService;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->middleware('guest')->except('logout');
        $this->accountService = $accountService;
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
    public function twitterCallback(Request $request)
    {
        $user = Socialite::driver('twitter')->user();
        $user_id = $this->accountService->checkIfTwitterAccountExists($user->id);
        if ($user_id) {
            Auth::loginUsingId($user_id);
            return redirect('/app');
        }
        $request->session()->put(['twitter' => $user]);
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
