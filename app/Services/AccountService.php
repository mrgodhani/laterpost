<?php namespace Laterpost\Services;


use Laterpost\Repositories\AccountRepository;

class AccountService
{
    /**
     * @var AccountRepository
     */
    private $accountRepo;

    /**
     * AccountService constructor.
     * @param AccountRepository $accountRepo
     */
    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    /**
     * Check if Twitter Account Already Exists
     * @param $profile_id
     * @return bool
     */
    public function checkIfTwitterAccountExists($profile_id)
    {
        $account = $this->accountRepo->findBy('profile_id',$profile_id);
        if(count($account) > 0) {
            return $account->user_id;
        } else {
            return false;
        }
    }
}