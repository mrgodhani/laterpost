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

    /**
     * Create new account entry
     * @param $data
     * @param $provider
     * @param $user_id
     * @return mixed
     */
    public function addAccount($data, $provider, $user_id)
    {
        if($this->checkIfTwitterAccountExists($data->id)) {
           return  $this->updateAccount($data,$user_id);
        } else {
            return $this->accountRepo->create([
                'token' => $data->token,
                'secret' => $data->tokenSecret ? $data->tokenSecret : null,
                'provider' => $provider,
                'username' => $data->nickname,
                'avatar' => $data->avatar,
                'profile_id' => $data->id,
                'user_id' => $user_id
            ]);
        }
    }

    /**
     * Update existing twitter account
     * @param $data
     * @param $user_id
     * @return mixed
     */
    public function updateAccount($data, $user_id) {
        return $this->accountRepo->update([
            'user_id' => $user_id
        ], $data->id,"profile_id");
    }
}