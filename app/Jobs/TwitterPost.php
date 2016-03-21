<?php

namespace LaterPost\Jobs;

use Illuminate\Support\Facades\Storage;
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

    private $imagefile;
    /**
     * @var
     */
    private $mime;

    /**
     * Create a new job instance.
     *
     * @param $media
     * @param $imagefile
     * @param $mime
     * @param $request
     */
    public function __construct($media,$imagefile,$mime,$request)
    {
        $this->media = $media;
        $this->imagefile = $imagefile;
        $this->request = $request;
        $this->mime = $mime;
    }

    /**
     * Execute the job.
     *
     * @param TwitterService $twitterService
     */
    public function handle(TwitterService $twitterService)
    {
        if($this->media){
            $file = Storage::disk('s3')->get($this->imagefile);
            $base64 = 'data:'.$this->mime.';base64,'.base64_encode($file);
        }
        $twitterService->status_update($this->media ? true : false,$this->media ? $file : null,$this->media ? $base64 : null,$this->request);
        if($this->media){
            $file = Storage::disk('s3')->delete($this->imagefile);
        }
    }
}
