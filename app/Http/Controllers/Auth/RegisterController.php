<?php

namespace Laterpost\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laterpost\Services\AccountService;
use Laterpost\User;
use Laterpost\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->middleware('guest');
        $this->accountService = $accountService;
    }

    /**
     * Sign up view only shown if it comes via Login for Twitter first time.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signupAccount()
    {
        // Check if there is session data. If not then redirect them back to Login
        if (!session('twitter')) {
            return redirect('/login');
        }
        return view('auth.signup');
    }

    /**
     *  Twitter Sign In (If account not available)
     *  Create User
     * @param Request $request
     * @return
     */

    public function registerUser(Request $request)
    {
        $this->validator($request->all())->validate();
        $twitter_data = $request->session()->get('twitter');

        try {
            $user = $this->create($request->all());
            event(new Registered($user));
            $this->accountService->addAccount($twitter_data,'twitter',$user->id);
            $request->session()->forget('twitter');
            $this->guard()->login($user);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());

        } catch (\Exception $e) {
            return redirect('/auth/signup')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
