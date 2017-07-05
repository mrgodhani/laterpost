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
}