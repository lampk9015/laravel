<?php

namespace Tests\Feature\Backend\Permission;

use App\Domains\Auth\Events\Permission\PermissionUpdated;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class UpdatePermissionTest.
 */
class UpdatePermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_name_is_required()
    {
        $permission = Permission::factory()->create();

        $this->loginAsAdmin();

        $response = $this->patch("/admin/auth/permission/{$permission->id}");

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_permission_name_can_be_updated()
    {
        Event::fake();

        $permission = Permission::factory()->create();

        $this->loginAsAdmin();

        $this->patch("/admin/auth/permission/{$permission->id}", [
            'type' => User::TYPE_ADMIN,
            'name' => 'user.update.test',
            'parent_id' => null,
        ]);

        $this->assertDatabaseHas('permissions', [
            'type' => User::TYPE_ADMIN,
            'name' => 'user.update.test',
            'parent_id' => null,
        ]);

        Event::assertDispatched(PermissionUpdated::class);
    }

    /** @test */
    public function only_admin_can_edit_permissions()
    {
        $this->loginAsAdmin();

        $permission = Permission::factory()->create();

        $this->get("/admin/auth/permission/{$permission->id}/edit")->assertOk();
    }

    /** @test */
    public function a_non_admin_can_not_edit_permissions()
    {
        $this->actingAs(User::factory()->user()->create());

        $permission = Permission::factory()->create();

        $response = $this->get("/admin/auth/permission/{$permission->id}/edit");

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }

    /** @test */
    public function only_admin_can_update_permissions()
    {
        $this->actingAs(User::factory()->user()->create());

        $permission = Permission::factory()->create(['name' => 'current name']);

        $response = $this->patch("/admin/auth/permission/{$permission->id}", [
            'name' => 'new name',
        ]);

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        // $this->assertDatabaseHas(config('permission.table_names.roles'), [
        //     'id'   => $permission->id,
        //     'name' => 'current name',
        // ]);
    }
}
