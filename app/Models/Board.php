<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillables = ['title', 'task_user_id'];

    /**
     * Get all of the task_users for the Board
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task_users(): HasMany
    {
        return $this->hasMany(TaskUser::class);
    }
}
