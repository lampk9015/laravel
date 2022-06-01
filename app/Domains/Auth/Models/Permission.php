<?php

namespace App\Domains\Auth\Models;

use App\Domains\Auth\Models\Traits\Attribute\PermissionAttribute;
use App\Domains\Auth\Models\Traits\Method\PermissionMethod;
use App\Domains\Auth\Models\Traits\Relationship\PermissionRelationship;
use App\Domains\Auth\Models\Traits\Scope\PermissionScope;
use Database\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

/**
 * Class Permission.
 */
class Permission extends SpatiePermission
{
    use HasFactory;
    use PermissionRelationship,
        PermissionAttribute,
        PermissionMethod,
        PermissionScope;

    /**
     * @var array
     */
    protected $appends = [
        'parent_name',
        'short_name',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PermissionFactory::new();
    }
}
