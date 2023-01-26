<?php

namespace App\Domains\Auth\Models\Traits\Method;

use Illuminate\Support\Facades\DB;

/**
 * Trait PermissionMethod.
 */
trait PermissionMethod
{
    /**
     * @return bool
     */
    public function hasParent(): bool
    {
        return $this->parent_id !== null;
    }

    /**
     * @return bool
     */
    public function hasChildren(): bool
    {
        return $this->children()->count() !== 0;
    }

    /**
     * @return bool
     */
    public function isDeletable(): bool
    {
        if ($this->getRoleNames()->count()) {
            return false;
        }

        $userIds = DB::table(config('permission.table_names.model_has_permissions'))
            ->select('model_id')
            ->where('permission_id', $this->id)
            ->where('model_type', "App\\Domains\\Auth\\Models\\User")
            ->get();

        if ($userIds->count()) {
            return false;
        }

        return true;
    }
}
