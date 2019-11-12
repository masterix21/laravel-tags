<?php

namespace Masterix21\LaravelTags\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'taggable_id',
        'taggable_type',
        'group',
        'value',
    ];

    /**
     * Get all of the owning model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function taggable()
    {
        return $this->morphTo();
    }
}
