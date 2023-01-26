<?php

namespace App\Domains\Auth\Http\Requests\Backend\Permission;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Validation\Permission\Rule as PermissionRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StorePermissionRequest.
 */
class StorePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', Rule::in([User::TYPE_ADMIN, User::TYPE_USER])],
            'name' => ['required', 'max:100', PermissionRule::unique_name()],
            'description' => ['max:255'],
            'parent_id' => [PermissionRule::parent()],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}
