<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ]; 

    // Project.php
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role', 'contribution_hours', 'last_activity');
    }

    public function latestTask()
    {
        return $this->hasOne(Task::class)->latestOfMany();
    }

    public function oldestTask()
    {
        return $this->hasOne(Task::class)->oldestOfMany();
    }
    public function highestPriorityTaskWithCondition($titleCondition)
    {
        return $this->tasks()
            ->where('title', 'like', '%' . $titleCondition . '%')
            ->ofMany('priority', 'min')
            ->first();
    }
}
