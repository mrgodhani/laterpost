<?php namespace LaterPost\Repository;

use Bosnadev\Repositories\Eloquent\Repository;

class UserRepo extends Repository
{
    public function model()
    {
        return 'LaterPost\User';
    }

}