<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'type',
        'type_id',
    ];
    public function commentable(): MorphTo
    {
        return $this->morphTo('type', 'type_id');
    }
}
