<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * عرض المهام بناءً على حالة المشروع.
     *
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($status)
    {
        $tasks = $this->taskService->getTasksByProjectStatus($status);
        return response()->json($tasks);
    }
}