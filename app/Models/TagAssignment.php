<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TagAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'tag_id',
        'type_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
