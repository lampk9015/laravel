<?php

namespace App\Domains\Auth\Validation\Permission;

use App\Domains\Auth\Rules\ParentPermissionIsNullOrExists;
use App\Domains\Auth\Rules\UniquePermissionNameWithPrefix;

class Rule
{
    /**
     * @return UniquePermissionNameWithPrefix
     */
    public static function unique_name()
    {
        return new UniquePermissionNameWithPrefix();
    }

    /**
     * @return ParentPermissionIsNullOrExists
     */
    public static function parent()
    {
        return new ParentPermissionIsNullOrExists();
    }
}
