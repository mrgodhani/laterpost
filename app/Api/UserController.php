<?php namespace LaterPost\Api;

use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use LaterPost\Api\Transformers\UserTransformer;
use LaterPost\Http\Requests;
use LaterPost\Services\UserService;

class UserController extends BaseController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return $this->response->item($user,new UserTransformer);
    }

    /**
     * Update user's timezone
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function updateTimezone(Request $request)
    {
        try {
            $this->userService->updateTimezone($request->get('timezone'));
            return $this->response->created();
        } catch(\Exception $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * Update Password
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     * @throws StoreResourceFailedException
     */
    public function updatePassword(Request $request)
    {
       $validator = Validator::make($request->all(),[
           'password' => 'required|confirmed|min:6',
       ]);
        if($validator->fails())
        {
            throw new StoreResourceFailedException('Missing fields.',$validator->errors());
        }
        $this->userService->updatePassword($request->get('password'));
        return $this->response->created();
    }

    /**
     * Update user's email
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function updateEmail(Request $request)
    {
        try {
            $this->userService->updateEmail($request->email);
            return $this->response->created();
        } catch (\Exception $e) {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            $this->userService->deleteAccount();
        } catch (\Exception $e)
        {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * Get Timezones
     * @return array
     */
    public function timezone()
    {
        return timezone_identifiers_list();
    }

    /**
     * Update Shortener Domain
     * @param Request $request
     */
    public function updateShortener(Request $request)
    {
        try {
            $this->userService->updateDomain($request->get('domain'));
        } catch (\Exception $e)
        {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
