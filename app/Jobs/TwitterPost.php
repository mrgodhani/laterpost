<?php

namespace LaterPost\Jobs;

use LaterPost\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaterPost\Services\TwitterService;

class TwitterPost extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    /**
     * @var
     */
    private $media;
    /**
     * @var
     */
    private $request;
    /**
     * @var
     */
    private $content;

    /**
     * Create a new job instance.
     *
     * @param $media
     * @param $content
     * @param $request
     */
    public function __construct($media,$content,$request)
    {
        $this->media = $media;
        $this->request = $request;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @param TwitterService $twitterService
     */
    public function handle(TwitterService $twitterService)
    {
        $twitterService->status_update($this->media ? true : false, $this->content,$this->request);
    }
}
