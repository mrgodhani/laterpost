<?php namespace LaterPost\Api;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use LaterPost\Services\AccountService;
use LaterPost\Services\UserService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Class AuthController
 * @package LaterPost\Http\Controllers\Auth
 */
class AuthController extends BaseController
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * AuthController constructor.
     * @param UserService $userService
     * @param AccountService $accountService
     */
    public function __construct(UserService $userService,AccountService $accountService)
    {
        $this->userService = $userService;
        $this->accountService = $accountService;
    }

    /**
     * Twitter Auth
     * @return mixed
     */
    public function twitter(Request $request)
    {
        $request->session()->put('uid',$request->get('user'));
        return Socialite::driver('twitter')->redirect();
    }

    /**
     * Twitter Callback
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function twitter_callback(Request $request){
        $user = Socialite::driver('twitter')->user();
        $this->accountService->create($user,$request->session()->get('uid'));
        $request->session()->forget('uid');
        return redirect('/');
    }

    /**
     * Register User
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request){

        $validation = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:4',
        ]);
        if($validation->fails()){
            throw new StoreResourceFailedException('Could not create new user.',$validation->errors());
        }
        $token = $this->userService->createUser($request->only('name','email','password'));
        return (new Response(compact('token'),200))->header('Content-Type','application/json');

    }

    /**
     * Login
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request){

        $validation = Validator::make($request->all(),[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        if($validation->fails()){
            throw new StoreResourceFailedException('Missing fields.',$validation->errors());
        }
        if(!$token = Auth::attempt($request->only('email','password'))){
            throw new UnauthorizedHttpException("Email or password isi invalid");
        }
        return (new Response(compact('token'),200))->header('Content-Type','application/json');
    }

    /**
     * Refresh token
     * @return mixed
     */
    public function refresh(){
        $token = Auth::refresh();
        return (new Response(compact('token'),200))->header('Content-Type','application/json');
    }
}
