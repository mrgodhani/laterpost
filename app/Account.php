<?php

namespace LaterPost;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    protected $table = "accounts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'secret', 'username','avatar','profile_id','user_id','provider'
    ];

    /**
     * Belongs to user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('LaterPost\User');
    }

    /**
     * Has many posts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany('LaterPost\Post');
    }
}
