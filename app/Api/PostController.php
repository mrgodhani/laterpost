<?php namespace LaterPost\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

use LaterPost\Http\Requests;
use LaterPost\Jobs\TwitterPost;
use LaterPost\Services\TwitterService;

class PostController extends BaseController
{
    use DispatchesJobs;

    /**
     * @var TwitterService
     */
    private $twitterService;

    /**
     * PostController constructor.
     * @param TwitterService $twitterService
     */
    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    /**
     * Post twitter status update
     * @param Request $request
     * @return array
     */
    public function tweet(Request $request){
        try
        {
            $job = (new TwitterPost(!is_null($request->file('image')) ? true : false,$request->get('content'),$request->only(['image','base64','accounts'])))->delay(1);
            $this->dispatch($job);
            $this->response->accepted();
        } catch (\Exception $e)
        {
           $this->response->errorBadRequest($e->getMessage());
        }
    }
}
