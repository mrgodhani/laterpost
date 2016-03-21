<?php namespace LaterPost\Repository;


use Bosnadev\Repositories\Eloquent\Repository;
use Carbon\Carbon;

class PostRepo extends Repository
{
    public function model()
    {
       return 'LaterPost\Post';
    }

    /**
     * Get Pending posts by current time
     * @return mixed
     */
    public function getPendingByCurrent()
    {
        return $this->model->where('scheduled_at',Carbon::now()->format('Y-m-d H:i'))->get();
    }

}