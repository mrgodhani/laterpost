<?php namespace LaterPost\Services;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use LaterPost\Repository\PostRepo;

class PostService
{
    /**
     * @var PostRepo
     */
    private $postRepo;

    /**
     * PostService constructor.
     * @param PostRepo $postRepo
     */
    public function __construct(PostRepo $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function createPost($image,$data){
        $accounts = collect(json_decode($data['accounts']))->toArray();
        $post = [];
        $file_name = null;
        $date =  Carbon::createFromFormat('Y/m/d H:i', $data['scheduled_at'], $data['timezone']);
        $date->setTimezone('UTC');
        foreach($accounts as $account)
        {
            if(!is_null($image)){
                $file_name = str_random(10).'.'.$image->getClientOriginalExtension();
                Storage::disk('s3')->put($file_name,fopen($image,'r'));
            }
            $post[]  = $this->postRepo->create([
                'content' => $data['content'],
                'media_path' => $file_name,
                'mimetype' => !is_null($image) ? $image->getMimeType() : NULL,
                'scheduled_at' => $date->toDateTimeString(),
                'profile_id' => $account->profile_id,
                'account_id' => $account->id,
            ]);
        }
        return collect($post);
    }

    public function deletePost($id)
    {
        $this->postRepo->delete($id);
    }
}