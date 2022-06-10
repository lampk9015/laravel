<?php

namespace App\Domains\Auth\Models;

use App\Abilities\HasParentModel;

use App\Domains\Auth\Models\AdminProfile;

/**
 * Class Admin.
 */
class Admin extends User
{
    use HasParentModel;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->where('type', self::TYPE_ADMIN);
        });
    }

    public function profile()
    {
        return $this->hasOne(AdminProfile::class, 'user_id', 'id');
    }
}
