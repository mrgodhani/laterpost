<?php namespace LaterPost\Services;


use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Storage;
use LaterPost\Jobs\TwitterPost;
use LaterPost\Repository\PostRepo;

class PostService
{
    use DispatchesJobs;
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

    /**
     * Queue Tweet
     * @param $image
     * @param $data
     */
    public function queueTweet($image,$data)
    {
        $file = null;
        if(!is_null($image)){
            $file = $image->getClientOriginalName();
            Storage::put($file,fopen($image,'r'));
        }
        $job = (new TwitterPost(!is_null($image) ? true : false,$file,!is_null($image) ? $image->getMimeType() : null ,$data))->delay(1);
        $this->dispatch($job);
    }

    /**
     * Create Post Item
     * @param $image
     * @param $data
     * @return \Illuminate\Support\Collection
     */
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
                Storage::put($file_name,fopen($image,'r'));
            }
            $post[]  = $this->postRepo->create([
                'content' => $data['content'],
                'media_path' => $file_name,
                'mimetype' => !is_null($image) ? $image->getMimeType() : NULL,
                'scheduled_at' => $date->format('Y-m-d H:i'),
                'profile_id' => $account->profile_id,
                'account_id' => $account->id,
            ]);
        }
        return collect($post);
    }

    /**
     * Update Post
     * @param $id
     * @param $image
     * @param $data
     * @return mixed
     */
    public function updatePost($id,$image,$data)
    {
        $current_post = $this->postRepo->find($id);
        $file_name = null;
        $mimetype = null;
        $date =  Carbon::createFromFormat('Y/m/d H:i',$data['scheduled_at'],$data['timezone']);
        $date->setTimezone('UTC');
        switch($image)
        {
            case "default":
                $file_name = $current_post->media_path;
                $mimetype = $current_post->mimetype;
                break;
            case null:
                if(!is_null($current_post->media_path)){
                    Storage::delete($current_post->media_path);
                }
                $file_name = null;
                $mimetype = null;
                break;
            default:
                if(!is_null($current_post->media_path)){
                    Storage::delete($current_post->media_path);
                }
                $file_name = str_random(10).'.'.$image->getClientOriginalExtension();
                $mimetype = $image->getMimeType();
                Storage::put($file_name,fopen($image,'r'));
                break;
        }
        $this->postRepo->update([
            'content' => $data['content'],
            'media_path' => $file_name,
            'mimetype' => $mimetype,
            'scheduled_at' => $date->format('Y-m-d H:i')
        ],$id);
        return [
            'content' => $data['content'],
            'media_path' => $file_name,
            'mimetype' => $mimetype,
            'scheduled_at' => $date->format('Y-m-d H:i')
        ];
    }

    /**
     * Delete post
     * @param $id
     */
    public function deletePost($id)
    {
        $this->postRepo->delete($id);
    }

    /**
     * Get Image
     * @param $id
     * @return string
     */
    public function getImage($id)
    {
        $post = $this->postRepo->find($id);
        $image = Storage::get($post->media_path);
        $data = [
            'mimeType' => $post->mimetype,
            'filename' => $post->media_path,
            'base64' => 'data:'.$post->mimetype.';base64,'.base64_encode($image)
        ];
        return $data;
    }
}