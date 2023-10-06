<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'job_role',
        'bio',
        'profile_photo_path'
    ];

    protected $with = [
      'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'employee_id');
    }

    public function completedTasks(): int
    {
        return $this->assignments()
            ->join('tasks', 'tasks.id', '=', 'assignments.task_id')
            ->where('tasks.status', '=', 'completed')
            ->count();
    }

    public function uncompletedTasks(): int
    {
        return $this->assignments()
            ->join('tasks', 'tasks.id', '=', 'assignments.task_id')
            ->where('tasks.status', '!=', 'completed')
            ->count();
    }
}
