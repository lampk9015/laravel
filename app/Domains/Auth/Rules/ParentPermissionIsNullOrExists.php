<?php

namespace App\Domains\Auth\Rules;

use App\Domains\Auth\Rules\Traits\PermissionTrait;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

/**
 * Class ParentPermissionIsNullOrExists.
 */
class ParentPermissionIsNullOrExists implements Rule
{
    use PermissionTrait;

    /**
     * @var
     */
    protected $input;

    /**
     * Create a new rule instance.
     *
     * ParentPermissionIsNullOrExists constructor.
     *
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
        if (! $value) {
            return true;
        }

        $validator = Validator::make([$attribute => $value], [
            $attribute => [
                \Illuminate\Validation\Rule::exists('permissions', 'id')->where('type', $this->input['type']),
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
        return __('Parent does not exists!');
    }
}
