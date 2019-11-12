<?php

namespace Masterix21\LaravelTags\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Masterix21\LaravelTags\Models\Tag;
use Orchestra\Testbench\TestCase;

class TagsTest extends TestCase
{
    use RefreshDatabase;

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__ .'/../database/migrations/create_tags_table.php.stub';

        (new \CreateTagsTable)->up();
    }

    /** @test */
    public function create_a_tag()
    {
        $tag = new Tag();
        $tag->fill([
            'taggable_id' => 1,
            'taggable_type' => self::class,
            'group' => 'group',
            'value' => 'random value',
        ]);
        $tag->save();

        return $this->assertSame(Tag::first()->value, $tag->value);
    }
}
