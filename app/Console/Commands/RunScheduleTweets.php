<?php

namespace LaterPost\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use LaterPost\Jobs\TwitterPost;
use LaterPost\Repository\AccountRepo;
use LaterPost\Repository\PostRepo;

class RunScheduleTweets extends Command
{
    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runtweets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run currently scheduled tweets';
    /**
     * @var PostRepo
     */
    private $postRepo;
    /**
     * @var AccountRepo
     */
    private $accountRepo;

    /**
     * Create a new command instance.
     *
     * @param PostRepo $postRepo
     * @param AccountRepo $accountRepo
     */
    public function __construct(PostRepo $postRepo,AccountRepo $accountRepo)
    {
        parent::__construct();
        $this->postRepo = $postRepo;
        $this->accountRepo = $accountRepo;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = $this->postRepo->getPendingByCurrent();
        $this->info(Carbon::now()->toDateTimeString());
        foreach($posts as $post)
        {
            $account = [];
            $account[] = $this->accountRepo->findBy('profile_id',$post->profile_id);
            $data = [
                'content' => $post->content,
                'accounts' => json_encode($account)
            ];
            $job = (new TwitterPost(!is_null($post->media_path) ? true : false,$post->media_path,$post->mimetype,$data))->delay(1);
            $this->dispatch($job);
            $this->postRepo->delete($post->id);
        }
        $this->info(count($posts).' queued');
    }
}
