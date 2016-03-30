<?php namespace LaterPost\Api\Transformers;


use LaterPost\Account;
use League\Fractal\TransformerAbstract;

class AccountTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'posts'
    ];

    public function transform(Account $account){
        return [
            'id' => $account->id,
            'username' => $account->username,
            'avatar' => $account->avatar,
            'profile_id' => $account->profile_id,
            'provider' => $account->provider
        ];
    }

    public function includePosts(Account $account)
    {
        return $this->collection($account->posts, new PostTransformer);
    }
}