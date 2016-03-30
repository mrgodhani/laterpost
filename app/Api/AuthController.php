<?php namespace LaterPost\Api;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
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
    use ResetsPasswords;
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
     * Bitly
     * @param Request $request
     * @return mixed
     */
    public function bitly(Request $request)
    {
        $request->session()->put('uid',$request->get('user'));
        return Socialite::driver('bitly')->redirect();
    }

    /**
     * Bitly Callback
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function bitly_callback(Request $request)
    {
        $user = Socialite::driver('bitly')->user();
        $check = $this->accountService->checkBitly($request->session()->get('uid'));
        if(!$check){
            $this->accountService->create($user,$request->session()->get('uid'),'bitly');
        }
        $request->session()->forget('uid');
        return redirect('/settings/shorteners');
    }

    /**
     * Twitter Callback
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function twitter_callback(Request $request){
        $user = Socialite::driver('twitter')->user();
        if($this->accountService->checkAccount($user->id)){
            $this->accountService->updateAccount($user,$request->session()->get('uid'));
        } else {
            $this->accountService->create($user,$request->session()->get('uid'),"twitter");
        }
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
            throw new UnauthorizedHttpException("Email or password is invalid");
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

    /**
     * Reset Password
     * @param Request $request
     */
    public function reset(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
        if($validate->fails())
        {
            $this->response->error($validate->errors(),400);
        }
        $response = Password::sendResetLink($request->only('email'),function(Message $message){
            $message->subject($this->getEmailSubject());
        });

        switch($response) {
            case Password::RESET_LINK_SENT:
                break;
            case Password::INVALID_USER:
                break;
        }
    }

    /**
     * Post Reset
     * @param Request $request
     */
    public function postReset(Request $request)
    {
        $this->validate($request,[
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $credentials = $request->only('email','password','password_confirmation','token');
    }


}
