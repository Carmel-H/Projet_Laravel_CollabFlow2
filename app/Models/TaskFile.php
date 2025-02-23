<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'count_download',
        'task_id'
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
