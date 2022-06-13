<?php

namespace App\Domains\Auth\Actions\Backend\Permission;

use App\Domains\Auth\Events\Permission\PermissionCreated;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Validation\Permission\Rule as PermissionRule;
use App\Exceptions\GeneralException;
use DB;
use Exception;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewPermission
{
    use AsAction;

    /**
     * @param  array  $data
     */
    public function handle(array $data)
    {
        return Permission::create($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
            'name' => ['required', 'max:100', PermissionRule::unique_name()],
            'description' => ['max:255'],
            'parent_id' => [PermissionRule::parent()],
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ActionRequest  $request
     * @return mixed
     *
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function asController(ActionRequest $request)
    {
        $input = resolve(PermissionService::class)->prepareInputFromRequest($request->except('_token'));

        DB::beginTransaction();

        try {
            $permission = $this->handle($input);
        } catch (Exception $e) {
            DB::rollBack();
            report($e);

            throw new GeneralException(__('There was a problem creating the permission.'));
        }

        event(new PermissionCreated($permission));

        DB::commit();

        return redirect()
            ->route('admin.auth.permission.index')
            ->withFlashSuccess(__('The Permission was successfully created.'));
    }

    /**
     * @param  PermissionCreated  $event
     */
    public function asListener(PermissionCreated $event): void
    {
        activity('permission')
            ->performedOn($event->permission)
            ->withProperties([
                'permission' => [
                    'type' => $event->permission->type,
                    'name' => $event->permission->name,
                    'description' => $event->permission->description,
                    'parent' => $event->permission->parent_name,
                ],
            ])
            ->log(':causer.name created permission :subject.name');
    }
}
