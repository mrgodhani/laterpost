<?php namespace LaterPost\Api;

use Illuminate\Http\Request;
use LaterPost\Api\Transformers\PostTransformer;
use LaterPost\Http\Requests;
use LaterPost\Jobs\TwitterPost;
use LaterPost\Services\PostService;
use LaterPost\Services\TwitterService;

class PostController extends BaseController
{

    /**
     * @var TwitterService
     */
    private $twitterService;
    /**
     * @var PostService
     */
    private $postService;

    /**
     * PostController constructor.
     * @param TwitterService $twitterService
     * @param PostService $postService
     */
    public function __construct(TwitterService $twitterService,PostService $postService)
    {
        $this->twitterService = $twitterService;
        $this->postService = $postService;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
           $post = $this->postService->createPost($request->file('image'),$request->only('scheduled_at','content','accounts','timezone'));
           return $this->response->collection($post,new PostTransformer);
        } catch(\Exception $e)
        {
            $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * Post twitter status update
     * @param Request $request
     * @return array
     */
    public function tweet(Request $request){
        try
        {
            $this->postService->queueTweet($request->file('image'),$request->only(['content','accounts']));
            $this->response->accepted();
        } catch (\Exception $e)
        {
           $this->response->errorBadRequest($e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function delete(Request $request)
    {
        try {
            $this->postService->deletePost($request->get('id'));
            return $this->response->created();
        } catch(\Exception $e)
        {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
