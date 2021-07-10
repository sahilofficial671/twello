<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasTasks;

class Task extends Model
{
    use HasFactory, HasTasks;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'task_user_id'];

    /**
     * Get the task_user that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task_user(): BelongsTo
    {
        return $this->belongsTo(TaskUser::class);
    }
}
