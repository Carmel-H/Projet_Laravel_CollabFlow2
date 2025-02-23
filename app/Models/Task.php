<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'due_date', 'status', 'project_id', 'user_id'];

    protected $casts = ['due_date' => 'datetime'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task_members(): HasMany
    {
        return $this->hasMany(TaskMember::class);
    }

    public function task_files(): HasMany
    {
        return $this->hasMany(TaskFile::class);
    }
}
