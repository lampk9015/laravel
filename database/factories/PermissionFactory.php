<?php

namespace Database\Factories;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PermissionFactory.
 */
class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $permissionIds = DB::table('permissions')->pluck('id')->toArray();

        $type = $this->faker->randomElement([User::TYPE_ADMIN, User::TYPE_USER]);
        $name = $this->faker->word;
        $parentId = $this->faker->randomElement(array_merge([null], $permissionIds));

        if (! is_null($parentId)) {
            $parent = DB::table('permissions')->where('id', $parentId)->first();
            $type = $parent->type;
            $name = $parent->name.'.'.$name;
        }

        return [
            'type' => $type,
            'name' => $name,
            'parent_id' => $parentId,
        ];
    }

    /**
     * @return PermissionFactory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_ADMIN,
            ];
        });
    }

    /**
     * @return PermissionFactory
     */
    public function user()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_USER,
            ];
        });
    }
}
