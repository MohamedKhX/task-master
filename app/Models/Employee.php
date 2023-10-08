<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use JetBrains\PhpStorm\NoReturn;
use Laravolt\Avatar\Facade as Avatar;

class Employee extends Model
{
    use HasFactory;

    const STORAGE_AVATAR_PATH = 'app/public/avatars/avatar-';
    const PUBLIC_AVATAR_PATH = 'storage/avatars/avatar-';

    protected $fillable = [
        'name',
        'user_id',
        'team_id',
        'job_role',
        'bio',
        'avatar_path'
    ];

    protected $with = [
        'user',
        'team:id,name'
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Employee $employee) {
            $employee->avatar_path = static::createAvatar($employee->id, $employee->name);
            $employee->save();
        });

        static::deleting(function (Employee $employee) {
            //Delete the avatar
            if(File::exists(public_path(Employee::PUBLIC_AVATAR_PATH . $employee->id . '.png'))) {
                File::delete(public_path(Employee::PUBLIC_AVATAR_PATH . $employee->id . '.png'));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'employee_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
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

    public static function createAvatar($id, $name): string
    {
        $path = storage_path(static::STORAGE_AVATAR_PATH);

        if (!file_exists($path)) {
            mkdir($path, 666, true);
        }

        Avatar::create($name)
            ->save($path . $id . '.png');

        return static::PUBLIC_AVATAR_PATH . $id . '.png';
    }

}
