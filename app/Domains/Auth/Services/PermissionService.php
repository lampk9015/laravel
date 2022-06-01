<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Events\Permission\PermissionCreated;
use App\Domains\Auth\Events\Permission\PermissionDeleted;
use App\Domains\Auth\Events\Permission\PermissionUpdated;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class PermissionService.
 */
class PermissionService extends BaseService
{
    /**
     * PermissionService constructor.
     *
     * @param  Permission  $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @param  array  $data
     *
     * @return Permission
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Permission
    {
        $input = $this->prepareInputFromRequest($data);

        DB::beginTransaction();

        try {
            $permission = $this->model::create($input);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            throw new GeneralException(__('There was a problem creating the permission.'));
        }

        event(new PermissionCreated($permission));

        DB::commit();

        return $permission;
    }

    /**
     * @param  Permission  $permission
     * @param  array  $data
     *
     * @return Role
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Permission $permission, array $data = []): Permission
    {
        $input = $this->prepareInputFromRequest($data);

        DB::beginTransaction();

        try {
            $permission->update($input);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            throw new GeneralException(__('There was a problem updating the permission.'));
        }

        event(new PermissionUpdated($permission));

        DB::commit();

        return $permission;
    }

    /**
     * @param  Permission  $permission
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Permission $permission): bool
    {
        if ($permission->getRoleNames()->count()) {
            throw new GeneralException(__('You can not delete a permission with associated roles.'));
        }

        $userIds = DB::table(config('permission.table_names.model_has_permissions'))
            ->select('model_id')
            ->where('permission_id', $permission->id)
            ->where('model_type', "App\\Domains\\Auth\\Models\\User")
            ->get();

        if ($userIds->count()) {
            throw new GeneralException(__('You can not delete a permission with associated users.'));
        }

        if ($this->deleteById($permission->id)) {
            event(new PermissionDeleted($permission));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the permission.'));
    }

    /**
     * @return mixed
     */
    public function getCategorizedPermissions()
    {
        return $this->model::isMaster()
            ->with('children')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getUncategorizedPermissions()
    {
        return $this->model::singular()
            ->orderBy('sort', 'asc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getAllPermissions()
    {
        return $this->model::orderBy('sort', 'asc')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getHierarchyPermissions()
    {
        return $this->model::whereNull('parent_id')
            ->with('children')
            ->orderBy('type', 'asc')
            ->orderBy('sort', 'asc')
            ->get();
    }

    /**
     * @param  array $data
     *
     * @return array
     */
    public function prepareInputFromRequest(array $data = []): array
    {
        $data['has_prefix'] = $data['has_prefix'] ?? (bool) $data['parent_id'];

        $input = [
            'type' => $data['type'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'sort' => $data['sort'] ?? Permission::where('type', $data['type'])
                ->where('parent_id', $data['parent_id'])
                ->pluck('sort')
                ->last() + 1,
        ];

        if ($data['has_prefix']) {
            $parent = $this->model::find($data['parent_id']);
            $prefix = (isset($parent->name) && ! Str::startsWith($input['name'], $parent->name . '.')) ? $parent->name . '.' : '';

            $input['name'] = $prefix . $input['name'];
        }

        return $input;
    }

    /**
     * @param  array  $data
     * @return Permission
     */
    public function createPermission(array $data = []): Permission
    {
        return $this->model::create([
            'type' => $data['type'] ?? User::TYPE_USER,
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
            'parent_id' => $data['parent_id'] ?? null,
            'sort' => $data['sort'] ?? 1,
        ]);
    }
}
