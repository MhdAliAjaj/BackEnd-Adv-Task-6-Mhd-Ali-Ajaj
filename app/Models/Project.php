<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;




    // Project.php
public function users()
{
    return $this->belongsToMany(User::class)
                ->withPivot('role', 'contribution_hours', 'last_activity');
}
}
