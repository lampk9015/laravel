<?php

namespace App\Domains\Auth\Models\Traits\Attribute;

/**
 * Trait PermissionAttribute.
 */
trait PermissionAttribute
{
    /**
     * @return string
     */
    public function getParentNameAttribute(): string
    {
        return $this->parent ? $this->parent->name : '';
    }

    /**
     * @return string
     */
    public function getShortNameAttribute(): string
    {
        return substr($this->name ?? '', $this->parent ? (strlen($this->parent_name) + 1) : 0);
    }
}
