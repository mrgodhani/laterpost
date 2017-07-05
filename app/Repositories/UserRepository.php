<?php
/**
 * Created by PhpStorm.
 * User: mgodhani
 * Date: 2017-07-05
 * Time: 2:27 PM
 */

namespace Laterpost\Repositories;


use Bosnadev\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{
    public function model()
    {
        return 'Laterpost\User';
    }

}