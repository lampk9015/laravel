@foreach($options as $option)
    <option value="{{ $option->id }}" x-show="userType === '{{ $option->type }}'" {{ $option->id == old('parent_id', $permission->parent_id) ? 'selected' : '' }}>{{ $option->name }}</option>
    @if($option->children->count())
        @include('backend.auth.permission.includes.parent-options', ['options' => $option->children])
    @endif
@endforeach
