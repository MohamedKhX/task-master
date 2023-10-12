<?php
use App\Models\Employee;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function get_tasks_without_sub_tasks()
    {
        $project = Project::factory()->create();

        $tasksWithoutSubTasks = Task::factory()->count(3)->create([
            'project_id' => $project->id,
            'parent_id' => null,
        ]);

        $tasksWithSubTasks = Task::factory()->count(2)->create([
            'project_id' => $project->id,
        ]);

        foreach ($tasksWithSubTasks as $taskWithSubTask) {
            $subTasks = Task::factory()->count(4)->create([
                'project_id' => $project->id,
                'parent_id' => $taskWithSubTask->id,
            ]);
        }

        $retrievedTasks = $project->tasksWithoutSubTasks;

        $this->assertCount(5, $retrievedTasks);
    }
}
