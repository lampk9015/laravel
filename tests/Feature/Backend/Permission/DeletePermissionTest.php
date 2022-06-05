<?php

namespace Tests\Feature\Backend\Permission;

use App\Domains\Auth\Events\Permission\PermissionDeleted;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeletePermissionTest.
 */
class DeletePermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_permission_can_be_deleted()
    {
        Event::fake();

        $permission = Permission::factory()->create();

        $this->loginAsAdmin();

        $this->assertDatabaseHas(config('permission.table_names.permissions'), ['id' => $permission->id]);

        $this->delete("/admin/auth/permission/{$permission->id}");

        $this->assertDatabaseMissing(config('permission.table_names.permissions'), ['id' => $permission->id]);

        Event::assertDispatched(PermissionDeleted::class);
    }

    /** @test */
    public function a_permission_with_assigned_users_cant_be_deleted()
    {
        $this->loginAsAdmin();

        $permission = Permission::factory()->create();

        $user = User::factory()->create();

        $user->givePermissionTo($permission);

        $response = $this->delete('/admin/auth/permission/'.$permission->id);

        $response->assertSessionHas(['flash_danger' => __('You can not delete a permission with associated users.')]);

        $this->assertDatabaseHas(config('permission.table_names.permissions'), ['id' => $permission->id]);
    }

    /** @test */
    public function only_admin_can_delete_permissions()
    {
        $this->actingAs(User::factory()->user()->create());

        $permission = Permission::factory()->create();

        $response = $this->delete('/admin/auth/permission/'.$permission->id);

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas(config('permission.table_names.permissions'), ['id' => $permission->id]);
    }
}
