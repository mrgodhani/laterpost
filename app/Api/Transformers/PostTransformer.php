<?php namespace LaterPost\Api\Transformers;


use LaterPost\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'content' => $post->content,
            'media_path' => $post->media_path,
            'mimetype' => $post->mimetype,
            'scheduled_at' => $post->scheduled_at,
            'account_id' => $post->account_id,
            'profile_id' => $post->profile_id
        ];
    }
}