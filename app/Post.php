<?php namespace LaterPost;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'media_path',
        'mimetype',
        'scheduled_at',
        'profile_id',
        'account_id'
    ];

    /**
     * Belongs to account
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        return $this->belongsTo('LaterPost\Account');
    }
}
