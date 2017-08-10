<?php

namespace Laterpost;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post.
 */
class Post extends Model
{
    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $fillable = [
        'content',
        'media_path',
        'mimetype',
        'scheduled_at',
        'profile_id',
        'account_id',
    ];

    /**
     * Belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Laterpost\User');
    }
}
