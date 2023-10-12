<?php
use App\Models\Assignment;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     * */
    public function assignment_belongs_to_employee()
    {
        $employee = Employee::factory()->create();
        $task = Task::factory()->create();
        $assignment = Assignment::factory()->create([
            'employee_id' => $employee->id,
            'task_id' => $task->id,
        ]);

        $assignedEmployee = $assignment->employee;
        $this->assertInstanceOf(Employee::class, $assignedEmployee);
        $this->assertEquals($employee->id, $assignedEmployee->id);
    }

}
