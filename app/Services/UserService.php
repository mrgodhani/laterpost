<?php namespace LaterPost\Services;


use Illuminate\Support\Facades\Auth;
use LaterPost\Repository\UserRepo;

/**
 * Class UserService
 * @package LaterPost\Services
 */
class UserService
{
    /**
     * @var UserRepo
     */
    private $userRepo;

    /**
     * UserService constructor.
     * @param UserRepo $userRepo
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Create new user
     * @param $data
     * @return mixed
     */
    public function createUser($data){
        $user = $this->userRepo->create($data);
        return Auth::generateTokenById(1);
    }
}