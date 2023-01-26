<?php

namespace Tests\Feature\Backend\Permission;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ListPermissionTest.
 */
class ListPermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_access_the_permission_index_page()
    {
        $this->loginAsAdmin();

        $this->get('/admin/auth/permission')->assertOk();
    }

    /** @test */
    public function only_admin_can_view_permissions()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/permission');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
