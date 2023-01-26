<?php

namespace App\Domains\Auth\Rules\Traits;

/**
 * Trait PermissionTrait.
 */
trait PermissionTrait
{
    /**
     * @param  array  $data
     *
     * @return self
     */
    public function constructInputData(array $data = []): self
    {
        $input = count($data) ? $data : request()->except('_token');

        $input['type'] = $input['type'] ?? '';
        $input['name'] = $input['name'] ?? '';
        $input['description'] = $input['description'] ?? '';
        $input['id'] = request()->permission->id ?? null;
        $input['parent_id'] = $input['parent_id'] ?? null;

        $this->input = $input;

        return $this;
    }
}
