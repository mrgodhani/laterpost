<?php namespace LaterPost\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        return Auth::generateTokenById($user->id);
    }

    /**
     *  Delete Account
     */
    public function deleteAccount(){
        $this->userRepo->delete(Auth::user()->id);
    }

    /**
     * Update user's password
     * @param $password
     */
    public function  updatePassword($password)
    {
        $this->userRepo->update(['password' => Hash::make($password)],Auth::user()->id);
    }

    /**
     * Update password by email
     * @param $email
     * @param $password
     */
    public function updatePasswordByEmail($email,$password)
    {
        $this->userRepo->update(['password' => Hash::make($password)],$email,'email');
    }

    /**
     * Update Email
     * @param $email
     */
    public function updateEmail($email){
        $this->userRepo->update(['email' => $email],Auth::user()->id);
    }

    /**
     * Update user's timezone
     * @param $timezone
     */
    public function updateTimezone($timezone){
        $this->userRepo->update(['timezone' => $timezone],Auth::user()->id);
    }

    /**
     * Update shortener domain
     * @param $domain
     */
    public function updateDomain($domain)
    {
        $this->userRepo->update(['default_shortener' => $domain],Auth::user()->id);
    }
}