<?php
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function it_generates_random_color_when_its_created()
    {
        $tag = new Tag();
        $tag->name = 'test';
        $tag->save();

        $this->assertNotNull($tag->color);
    }
}
