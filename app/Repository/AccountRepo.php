<?php namespace LaterPost\Repository;


use Bosnadev\Repositories\Eloquent\Repository;

class AccountRepo extends Repository
{
    public function model()
    {
       return 'LaterPost\Account';
    }

    /**
     * Check bitly account
     * @param $userid
     * @return bool
     */
    public function checkBitly($userid)
    {
        $account = $this->model->where('user_id',$userid)->where('provider','bitly')->get();
        if(count($account) > 0)
        {
            return true;
        }
        return false;
    }

    /**
     * Get Bitly Token
     * @param $id
     * @return mixed
     */
    public function getBitlyToken($id)
    {
        $account = $this->model->where('user_id',$id)->where('provider','bitly')->first();
        return $account->token;
    }

    /**
     * Delete Bitly ID
     * @param $user_id
     */
    public function deleteBitlyAccount($user_id)
    {
        $this->model->where('user_id',$user_id)->where('provider','bitly')->delete();
    }
}