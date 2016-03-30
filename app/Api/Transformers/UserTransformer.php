<?php namespace LaterPost\Api\Transformers;


use LaterPost\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'accounts'
    ];

    public function transform(User $user){
        return [
            'id' => (int) $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'timezone' => $user->timezone,
            'default_shortener' => $user->default_shortener
        ];
    }

    public function includeAccounts(User $user){
        return $this->collection($user->accounts,new AccountTransformer);
    }
}