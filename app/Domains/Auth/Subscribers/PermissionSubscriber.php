<?php

namespace App\Domains\Auth\Subscribers;

use App\Domains\Auth\Actions\Backend\Permission\CreateNewPermission;
use App\Domains\Auth\Events\Permission\PermissionCreated;

/**
 * Class PermissionSubscriber.
 */
class PermissionSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(PermissionCreated::class, CreateNewPermission::class);
    }
}
