    <x-utils.edit-button :href="route('admin.auth.permission.edit', $model)" />
@if ($model->isDeletable())
    <x-utils.delete-button :href="route('admin.auth.permission.destroy', $model)" />
@endif
