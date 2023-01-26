<div x-data="{userType : '{{ old('type', $permission->type) }}'}">
    <div class="form-group row">
        <label for="type" class="col-md-2 col-form-label">@lang('Type')</label>

        <div class="col-md-10">
            <select name="type" class="form-control" required x-on:change="userType = $event.target.value; $('select[name=parent_id]').val('')">
                <option value="{{ $model::TYPE_ADMIN }}" :selected="userType === '{{ $model::TYPE_ADMIN }}'">@lang('Administrator')</option>
                <option value="{{ $model::TYPE_USER }}" :selected="userType === '{{ $model::TYPE_USER }}'">@lang('User')</option>
            </select>
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

        <div class="col-md-10">
            <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name', $permission->short_name) }}" maxlength="100" required />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="description" class="col-md-2 col-form-label">@lang('Description')</label>

        <div class="col-md-10">
            <input type="text" name="description" class="form-control" placeholder="{{ __('Description') }}" value="{{ old('description', $permission->description) }}" maxlength="255" required />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="parent_id" class="col-md-2 col-form-label">@lang('Parent')</label>

        <div class="col-md-10">
            <select name="parent_id" class="form-control">
                <option value="">NO PARENT</option>
                @include('backend.auth.permission.includes.parent-options', ['options' => $parentOptions])
            </select>
        </div>
    </div><!--form-group-->
</div>
