<div class="form-group row">
    <label for="title" class="col-md-2 col-form-label text-md-right">@lang('Title')</label>

    <div class="col-md-8">
        <input type="text" name="title" class="form-control" placeholder="{{ __('Title') }}" value="{{ old('title') ?? $task->title }}" required autofocus autocomplete="title" />
    </div>
</div><!--form-group-->

<div class="form-group row">
    <label for="description" class="col-md-2 col-form-label text-md-right">@lang('Description')</label>

    <div class="col-md-8">
        <textarea name="description" class="form-control rounded">{{ old('description') ?? $task->description }}</textarea>
        @if ($errors->has('description'))
            <span class="text-danger">{{ $errors->first('description') }}</span>
        @endif
    </div>
</div><!--form-group-->

<div class="form-group row">
    <label for="deadline_at" class="col-md-2 col-form-label text-md-right">@lang('Deadline At')</label>

    <div class="col-md-8">
        <div class="input-group date" id="deadline-at-dt-picker" data-target-input="nearest">
            <input type="text" name="deadline_at" class="form-control datetimepicker-input" data-target="#deadline-at-dt-picker" value="{{ old('deadline_at') ?? $task->deadline_at }}" />
            <div class="input-group-append" data-target="#deadline-at-dt-picker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
            </div>
        </div>
    </div>
</div><!--form-group-->

<div class="form-group row mb-0">
    <div class="col-md-10 text-right">
        <button class="btn btn-sm btn-primary" type="submit">{{ $submitBtnLabel }}</button>
        <a href="{{ route('frontend.tasks.index') }}" class="btn btn-sm btn-light" type="submit">@lang('Cancel')</a>
    </div>
</div><!--form-group-->
