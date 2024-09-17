<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;

// مسارات المصادقة باستخدام JWT
Route::group(['middleware' => 'api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user-profile', [AuthController::class, 'userProfile']);
});

// مسارات المشاريع - محمية حسب الأدوار
Route::group(['middleware' => ['auth:api', 'role:manager']], function () {
    Route::post('projects/create', [ProjectController::class, 'store']); // إنشاء مشروع جديد
    Route::put('projects/update/{id}', [ProjectController::class, 'update']); // تعديل مشروع
    Route::delete('projects/delete/{id}', [ProjectController::class, 'destroy']); // حذف مشروع
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('projects', [ProjectController::class, 'index']); // جلب جميع المشاريع
    Route::get('projects/{id}', [ProjectController::class, 'show']); // جلب مشروع محدد
});

// مسارات المهام - محمية حسب الأدوار
Route::group(['middleware' => ['auth:api', 'role:manager']], function () {
    Route::post('projects/{project_id}/tasks/create', [TaskController::class, 'store']); // إنشاء مهمة جديدة
    Route::put('tasks/update/{id}', [TaskController::class, 'update']); // تعديل مهمة
    Route::delete('tasks/delete/{id}', [TaskController::class, 'destroy']); // حذف مهمة
});

Route::group(['middleware' => ['auth:api', 'role:developer']], function () {
    Route::put('tasks/update-status/{id}', [TaskController::class, 'updateStatus']); // تعديل حالة المهمة
});

Route::group(['middleware' => ['auth:api', 'role:tester']], function () {
    Route::post('tasks/{id}/add-note', [TaskController::class, 'addNote']); // إضافة ملاحظة اختبارية
});

/

// مسار عام للترحيب
Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the Team Project Management System API']);
});