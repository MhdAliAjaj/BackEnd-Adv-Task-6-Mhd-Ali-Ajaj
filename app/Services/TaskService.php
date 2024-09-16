<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    /**
     * الحصول على المهام بناءً على حالة المشروع.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getTasksByProjectStatus(string $status)
    {
        return Task::whereRelation('project', 'status', $status)->get();
    }

    // يمكنك إضافة طرق أخرى هنا لإدارة المهام
}