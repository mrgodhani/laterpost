<?php

namespace Laterpost;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * @package Laterpost
 */
class Account extends Model
{

    /**
     * @var string
     */
    protected $table = 'accounts';

    /**
     * @var array
     */
    protected $fillable = [
        'token',
        'secret',
        'provider',
        'username',
        'avatar',
        'profile_id',
        'user_id'
    ];

    /**
     * Belongs to User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('Laterpost\User');
    }
}
