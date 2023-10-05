<?php

namespace App\Models;

use App\View\Components\Table\Priority;
use Carbon\AbstractTranslator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Blade;

/**
 * @method static create(array $array)
 * @method tasks()
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'priority',
        'project_id',
        'start_date',
        'end_date',
        'parent_id',
        'completed_at',
    ];



    protected $with = [
        'tags',
        'assignments'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'employee_id');
    }

    public function subTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
