<?php namespace LaterPost\Repository;


use Bosnadev\Repositories\Eloquent\Repository;

class AccountRepo extends Repository
{
    public function model()
    {
       return 'LaterPost\Account';
    }
}