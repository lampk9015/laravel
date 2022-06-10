<?php

namespace App\Domains\Auth\Models\Traits\Relationship;

use App\Domains\Auth\Models\AdminProfile;
use App\Domains\Auth\Models\CustomerProfile;
use App\Domains\Auth\Models\PasswordHistory;
use App\Domains\Auth\Models\SaleProfile;
use App\Domains\Auth\Models\StaffProfile;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->morphMany(PasswordHistory::class, 'model');
    }

    /**
     * @return mixed
     */
    // public function profiles()
    // {
    //     return $this->hasMany(Profile::class);
    // }

    /**
     * @return mixed
     */
    // public function adminProfile()
    // {
    //     return $this->hasOne(AdminProfile::class, 'user_id');
    // }

    /**
     * @return mixed
     */
    // public function customerProfile()
    // {
    //     return $this->hasOne(CustomerProfile::class, 'user_id');
    // }

    /**
     * @return mixed
     */
    // public function saleProfile()
    // {
    //     return $this->hasOne(SaleProfile::class, 'user_id');
    // }

    /**
     * @return mixed
     */
    // public function staffProfile()
    // {
    //     return $this->hasOne(StaffProfile::class, 'user_id');
    // }
}
