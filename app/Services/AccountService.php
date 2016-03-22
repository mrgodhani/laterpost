<?php
/**
 * Created by PhpStorm.
 * User: meetgodhani
 * Date: 2016-03-19
 * Time: 10:50 PM
 */

namespace LaterPost\Services;


use Illuminate\Support\Facades\Auth;
use LaterPost\Repository\AccountRepo;

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
    public function create($data,$user_id)
    {
        $this->accountRepo->create([
            'token' => $data->token,
            'secret' => $data->tokenSecret,
            'username' => $data->nickname,
            'avatar' => $data->avatar_original,
            'profile_id' => $data->id,
            'user_id' => $user_id
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
}