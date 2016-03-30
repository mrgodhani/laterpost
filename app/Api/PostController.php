<?php namespace LaterPost\Api;

use Illuminate\Http\Request;
use LaterPost\Api\Transformers\PostTransformer;
use LaterPost\Http\Requests;
use LaterPost\Jobs\TwitterPost;
use LaterPost\Services\BitlyService;
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
     * @var BitlyService
     */
    private $bitlyService;

    /**
     * PostController constructor.
     * @param TwitterService $twitterService
     * @param PostService $postService
     * @param BitlyService $bitlyService
     */
    public function __construct(TwitterService $twitterService,PostService $postService,BitlyService $bitlyService)
    {
        $this->twitterService = $twitterService;
        $this->postService = $postService;
        $this->bitlyService = $bitlyService;
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
     * Update specific post
     * @param $id
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function update($id,Request $request)
    {
        try {
            if(!is_null($request->file('image')))
            {
                $image = $request->file('image');
            } else if($request->has('image') && is_null($request->file('image')))
            {
                $image = null;
            } else {
                $image = "default";
            }
            $data = $request->only('scheduled_at','content','timezone');
            return $this->postService->updatePost($id,$image,$data);
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
     * Get current post attached image
     * @param $id
     * @return string
     */
    public function getImage($id)
    {
        try {
            return response($this->postService->getImage($id))->header('Content-Type', 'image/png');
        } catch(\Exception $e)
        {
            $this->response->errorNotFound();
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

    /**
     * Shorten Link
     * @param Request $request
     * @return mixed
     */
    public function shorten(Request $request)
    {
        try {
            return $this->bitlyService->shortenLink($request->get('link'));
        } catch(\Exception $e)
        {
            $this->response->errorBadRequest($e->getMessage());
        }
    }
}
