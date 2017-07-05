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
}