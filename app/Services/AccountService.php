<?php namespace LaterPost\Services;


use Illuminate\Support\Facades\Auth;
use LaterPost\Repository\AccountRepo;

/**
 * Class AccountService
 * @package LaterPost\Services
 */
class AccountService
{
    /**
     * @var AccountRepo
     */
    private $accountRepo;

    /**
     * AccountService constructor.
     * @param AccountRepo $accountRepo
     */
    public function __construct(AccountRepo $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    /**
     * Check Account
     * @param $profile_id
     * @return bool
     */
    public function checkAccount($profile_id)
    {
        $accounts = $this->accountRepo->findBy('profile_id',$profile_id);
        if(count($accounts) > 0){
            return true;
        }
        return false;
    }

    /**
     * Check bitly.
     * @param $user_id
     * @return bool
     */
    public function checkBitly($user_id)
    {
        return $this->accountRepo->checkBitly($user_id);
    }

    /**
     * Update Account
     * @param $user_id
     */
    public function updateAccount($user,$user_id)
    {
        $account = $this->accountRepo->findBy('profile_id',$user->id);
        $this->accountRepo->delete($account->id);
        $this->create($user,$user_id);
    }

    /**
     * @param $data
     */
    public function create($data,$user_id,$provider)
    {
        $this->accountRepo->create([
            'token' => $data->token,
            'secret' => isset($data->tokenSecret) ? $data->tokenSecret : NULL,
            'username' => !is_null($data->nickname) ? $data->nickname : NULL,
            'avatar' => isset($data->avatar_original) ? $data->avatar_original : NULL,
            'profile_id' => !is_null($data->id) ? $data->id : NULL,
            'user_id' => $user_id,
            'provider' => $provider
        ]);
    }

    /**
     * Delete Account
     * @param $id
     */
    public function delete($id)
    {
        $this->accountRepo->delete($id);
    }

    /**
     * Delete Bitly
     */
    public function deleteBitlyAccount()
    {
        $this->accountRepo->deleteBitlyAccount(Auth::user()->id);
    }
}