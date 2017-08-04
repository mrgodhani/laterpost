<?php namespace Laterpost\Services;


use Laterpost\Repositories\UserRepository;

class UserServices
{
    /**
     * @var UserRepository
     */
    private $userRepo;

    /**
     * UserServices constructor.
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    /**
     * Check if user has Twitter accounts
     * @param $user_id
     * @return bool
     */
    public function userHasTwitter($user_id) {
        $user = $this->userRepo->find($user_id);
        if($user->accounts->count() > 0) {
            return true;
        }
        return false;
    }

    public function createUser($user)
    {
        
    }
}