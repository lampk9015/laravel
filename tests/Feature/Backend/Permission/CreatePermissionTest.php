<?php

namespace Tests\Feature\Backend\Permission;

use App\Domains\Auth\Events\Permission\PermissionCreated;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreatePermissionTest.
 */
class CreatePermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_create_permission_page()
    {
        $this->loginAsAdmin();

        $this->get('/admin/auth/permission/create')->assertOk();
    }

    /** @test */
    public function create_permission_requires_validation()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/permission');

        $response->assertSessionHasErrors(['type', 'name']);
    }

    /** @test */
    public function the_permission_name_must_be_unique()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/permission', [
            'name' => 'admin.access.user',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_permission_can_be_created()
    {
        Event::fake();

        $this->loginAsAdmin();

        $this->post('/admin/auth/permission', [
            'type' => User::TYPE_USER,
            'name' => 'user.new.test',
            'parent_id' => null,
        ]);

        $this->assertDatabaseHas('permissions', [
            'type' => User::TYPE_USER,
            'name' => 'user.new.test',
            'parent_id' => null,
        ]);

        Event::assertDispatched(PermissionCreated::class);
    }

    /** @test */
    public function only_admin_can_create_permissions()
    {
        $this->actingAs(User::factory()->user()->create());

        $response = $this->get('/admin/auth/permission/create');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
