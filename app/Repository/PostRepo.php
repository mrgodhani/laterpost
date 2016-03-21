<?php namespace LaterPost\Repository;


use Bosnadev\Repositories\Eloquent\Repository;

class PostRepo extends Repository
{
    public function model()
    {
       return 'LaterPost\Post';
    }

}