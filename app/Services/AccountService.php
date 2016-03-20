<?php
/**
 * Created by PhpStorm.
 * User: meetgodhani
 * Date: 2016-03-19
 * Time: 10:50 PM
 */

namespace LaterPost\Services;


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
}