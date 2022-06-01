<?php

namespace App\Domains\Auth\Rules;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Rules\Traits\PermissionTrait;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class UniquePermissionNameWithPrefix.
 */
class UniquePermissionNameWithPrefix implements Rule
{
    use PermissionTrait;

    /**
     * @var
     */
    protected $input;

    /**
     * Create a new rule instance.
     *
     * ParentPermissionNullOrExists constructor.
     *
     * @param  array  $input
     */
    public function __construct(array $data = [])
    {
        $this->constructInputData($data);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $parent = Permission::find([
            'id' => $this->input['parent_id'],
            'type' => $this->input['type'],
        ]);
        $prefix = (isset($parent->name) && ! Str::startsWith($this->input['name'], $parent->name . '.')) ? $parent->name . '.' : '';

        $validator = Validator::make([$attribute => $prefix . $value], [
            $attribute => [
                \Illuminate\Validation\Rule::unique('permissions')->ignore($this->input['id']),
            ],
        ]);

        $validator->validate();

        return $validator->fails() === false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('The name has already been taken.');
    }
}
