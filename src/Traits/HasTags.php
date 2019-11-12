<?php

namespace Masterix21\LaravelTags\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTags
{
    public static function bootHasTags()
    {
        static::deleting(static function ($model) {
            $model->tags()->delete();
        });
    }

    /**
     * Get all model tags
     *
     * @return MorphMany
     */
    public function tags()
    {
        return $this->morphMany(config('tags.models.tag'), 'taggable');
    }

    /**
     * Retag the model deleting old tags and applying new ones.
     *
     * @param $tags
     * @param null $group
     */
    public function retag($tags, $group = null)
    {
        $this->tags()->when($group, function ($query) use ($group) {
            $query->where('group', $group);
        })->delete();

        $tags = collect($tags)->map(function ($tag) use ($group) {
            if (! is_string($tag)) {
                $tag = data_get($tag, 'value');
            }

            return (new config('tags.models.tag'))->fill([
                'taggable_id' => $this->id,
                'taggable_type' => get_class($this),
                'group' => $group,
                'value' => $tag,
            ]);
        });

        $this->tags()->saveMany($tags);
    }
}
