<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'path',
        'mime',
        'owner_id',

        'users',
        'groups',
        'organizations',
        'lifetime',
        'is_public',
    ];

    protected $casts = [
        'users' => 'array',
        'groups' => 'array',
        'organizations' => 'array',
        'is_public' => 'boolean'
    ];

    /**
     * An organization belongs to an user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

}
