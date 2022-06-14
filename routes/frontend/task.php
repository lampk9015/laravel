<?php

use App\Domains\Task\Http\Controllers\Frontend\TaskController;
use App\Domains\Task\Models\Task;
use Tabuna\Breadcrumbs\Trail;

Route::group([
    'prefix' => 'tasks',
    'as' => 'tasks.',
    'middleware' => 'auth',
], function () {
    Route::get('/', [TaskController::class, 'index'])
        ->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('My Task'), route('frontend.tasks.index'));
        });

    Route::get('create', [TaskController::class, 'create'])
        ->name('create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.tasks.index')
                ->push(__('Create Task'), route('frontend.tasks.create'));
        });

    Route::post('/', [TaskController::class, 'store'])->name('store');

    Route::group(['prefix' => '{task}'], function () {
        Route::get('edit', [TaskController::class, 'edit'])
            ->name('edit')
            ->breadcrumbs(function (Trail $trail, Task $task) {
                $trail->parent('frontend.tasks.index')
                    ->push(__('Editing :task', ['task' => $task->title]), route('frontend.tasks.edit', $task));
            });

        Route::patch('/', [TaskController::class, 'update'])->name('update');
        Route::patch('/mark-as-completed', [TaskController::class, 'markAsCompleted'])->name('mark-as-completed');
        Route::delete('/', [TaskController::class, 'destroy'])->name('destroy');
    });
});
