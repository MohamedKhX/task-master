<?php

namespace Tests\Unit;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sync_tags_works_correctly()
    {
        $task = Task::factory()->create();

        $tagNames = ['Tag 1', 'Tag 2', 'Tag 3'];

        $task->syncTags($tagNames);

        $tags = $task->tags;

        $this->assertCount(count($tagNames), $tags);

        foreach ($tags as $tag) {
            $this->assertContains($tag->name, $tagNames);
        }
    }
}
