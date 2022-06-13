<?php
use App\Domains\Auth\Actions\Backend\Permission\CreateNewPermission;
use App\Domains\Auth\Http\Controllers\Backend\Permission\PermissionController;
use App\Domains\Auth\Models\Permission;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.auth'.
Route::group([
    'prefix' => 'auth',
    'as' => 'auth.',
    'middleware' => config('boilerplate.access.middleware.confirm'),
], function () {
    Route::group([
        'prefix' => 'permission',
        'as' => 'permission.',
        'middleware' => 'role:'.config('boilerplate.access.role.admin'),
    ], function () {
        Route::get('/', [PermissionController::class, 'index'])
            ->name('index')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.dashboard')
                    ->push(__('Permission Management'), route('admin.auth.permission.index'));
            });

        Route::get('create', [PermissionController::class, 'create'])
            ->name('create')
            ->breadcrumbs(function (Trail $trail) {
                $trail->parent('admin.auth.permission.index')
                    ->push(__('Create Permission'), route('admin.auth.permission.create'));
            });

        // Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::post('/', CreateNewPermission::class)->name('store');

        Route::group(['prefix' => '{permission}'], function () {
            Route::get('edit', [PermissionController::class, 'edit'])
                ->name('edit')
                ->breadcrumbs(function (Trail $trail, Permission $permission) {
                    $trail->parent('admin.auth.permission.index')
                        ->push(__('Editing :permission', ['permission' => $permission->name]), route('admin.auth.permission.edit', $permission));
                });

            Route::patch('/', [PermissionController::class, 'update'])->name('update');
            Route::delete('/', [PermissionController::class, 'destroy'])->name('destroy');
        });
    });
});
