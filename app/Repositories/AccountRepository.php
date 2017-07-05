<?php namespace Laterpost\Repositories;


use Bosnadev\Repositories\Eloquent\Repository;

class AccountRepository extends Repository
{
    public function model()
    {
       return 'Laterpost\Account';
    }

}