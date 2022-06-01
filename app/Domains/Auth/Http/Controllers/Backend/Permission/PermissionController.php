<?php

namespace App\Domains\Auth\Http\Controllers\Backend\Permission;

use App\Domains\Auth\Http\Requests\Backend\Permission\DeletePermissionRequest;
use App\Domains\Auth\Http\Requests\Backend\Permission\EditPermissionRequest;
use App\Domains\Auth\Http\Requests\Backend\Permission\StorePermissionRequest;
use App\Domains\Auth\Http\Requests\Backend\Permission\UpdatePermissionRequest;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\PermissionService;
use Illuminate\Routing\Controller;

/**
 * Class PermissionController.
 */
class PermissionController extends Controller
{
    /**
     * @var PermissionService
     */
    protected $permissionService;

    /**
     * PermissionController constructor.
     *
     * @param  PermissionService  $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('backend.auth.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $parentOptions = $this->permissionService->getHierarchyPermissions();

        return view('backend.auth.permission.create')
            ->withParentOptions($parentOptions)
            ->withEmptyPermission(Permission::query()->newModelInstance([
                'type' => User::TYPE_ADMIN,
            ]));
    }

    /**
     * Store a newly created resource in storage.
     * @param  StorePermissionRequest  $request
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StorePermissionRequest $request)
    {
        $this->permissionService->store($request->validated());

        return redirect()
            ->route('admin.auth.permission.index')
            ->withFlashSuccess(__('The Permission was successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EditPermissionRequest  $request
     * @param  Permission  $permission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(EditPermissionRequest $request, Permission $permission)
    {
        $parentOptions = $this->permissionService->getHierarchyPermissions();

        return view('backend.auth.permission.edit')
            ->withParentOptions($parentOptions)
            ->withPermission($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePermissionRequest  $request
     * @param  Permission $permission
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->permissionService->update($permission, $request->validated());

        return redirect()
            ->route('admin.auth.permission.index')
            ->withFlashSuccess(__('The Permission was successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeletePermissionRequest  $request
     * @param  Permission  $permission
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy(DeletePermissionRequest $request, Permission $permission)
    {
        $this->permissionService->destroy($permission);

        return redirect()
            ->route('admin.auth.permission.index')
            ->withFlashSuccess(__('The Permission was successfully deleted.'));
    }
}
