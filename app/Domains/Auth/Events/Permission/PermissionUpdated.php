<?php

namespace App\Domains\Auth\Events\Permission;

use App\Domains\Auth\Models\Permission;
use Illuminate\Queue\SerializesModels;

/**
 * Class PermissionUpdated.
 */
class PermissionUpdated
{
    use SerializesModels;

    /**
     * @var
     */
    public $permission;

    /**
     * @param $permission
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }
}
