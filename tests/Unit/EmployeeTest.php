<?php

use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake();
    }

    protected function tearDown(): void
    {
        File::cleanDirectory(storage_path('app/public/avatars'));
        parent::tearDown();
    }

    /** @test */
    public function it_creates_avatar_when_its_created()
    {
        $employee = Employee::factory()->create();

        $expectedPath = 'storage/avatars/avatar-' . $employee->id . '.png';

        $actualPath = Employee::createAvatar($employee->id, $employee->name);

        $this->assertEquals($expectedPath, $actualPath);

        Storage::disk('public')->assertExists('avatars/avatar-' . $employee->id . '.png');
    }

    /** @test */
    public function get_completed_tasks_count_correctly()
    {
        $employee = Employee::factory()->create();

        $completedTasks = Task::factory(3)->create([
            'status' => \App\Enums\TaskStatus::COMPLETED,
            'created_by' => $employee->id
        ]);

        $uncompletedTasks = Task::factory(2)->create([
            'status' => \App\Enums\TaskStatus::IN_PROGRESS,
            'created_by' => $employee->id
        ]);

        foreach ($completedTasks as $task) {
            Assignment::factory()->create([
                'employee_id' => $employee->id,
                'task_id' => $task->id,
            ]);
        }

        foreach ($uncompletedTasks as $task) {
            Assignment::factory()->create([
                'employee_id' => $employee->id,
                'task_id' => $task->id,
            ]);
        }

        $completedTaskCount = $employee->completedTasks();

        $this->assertEquals(count($completedTasks), $completedTaskCount);
    }

    /** @test */
    public function get_uncompleted_tasks_count_correctly()
    {
        $employee = Employee::factory()->create();

        $completedTasks = Task::factory(3)->create([
            'status' => \App\Enums\TaskStatus::COMPLETED,
            'created_by' => $employee->id
        ]);

        $uncompletedTasks = Task::factory(2)->create([
            'status' => \App\Enums\TaskStatus::IN_PROGRESS,
            'created_by' => $employee->id
        ]);

        foreach ($completedTasks as $task) {
            Assignment::factory()->create([
                'employee_id' => $employee->id,
                'task_id' => $task->id,
            ]);
        }

        foreach ($uncompletedTasks as $task) {
            Assignment::factory()->create([
                'employee_id' => $employee->id,
                'task_id' => $task->id,
            ]);
        }

        $uncompletedTaskCount = $employee->uncompletedTasks();

        $this->assertEquals(count($uncompletedTasks), $uncompletedTaskCount);
    }
}
