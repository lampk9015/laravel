<?php

namespace App\Domains\Auth\Listeners;

use App\Domains\Auth\Events\Permission\PermissionCreated;
use App\Domains\Auth\Events\Permission\PermissionDeleted;
use App\Domains\Auth\Events\Permission\PermissionUpdated;

/**
 * Class PermissionEventListener.
 */
class PermissionEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
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

    /**
     * @param $event
     */
    public function onUpdated($event)
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
            ->log(':causer.name updated permission :subject.name');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('permission')
            ->performedOn($event->permission)
            ->log(':causer.name deleted permission :subject.name');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(PermissionCreated::class, [static::class, 'onCreated']);

        $events->listen(PermissionUpdated::class, [static::class, 'onUpdated']);

        $events->listen(PermissionDeleted::class, [static::class, 'onDeleted']);
    }
}
