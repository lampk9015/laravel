<x-utils.edit-button class="btn-outline-secondary" :href="route('frontend.tasks.edit', $task)" />
<x-utils.delete-button :href="route('frontend.tasks.destroy', $task)" />

@if (!$task->is_completed)
    <div class="dropdown d-inline-block">
        <a class="btn btn-sm btn-secondary dropdown-toggle" id="moreMenuLink" href="#" role="button" data-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
            @lang('More')
        </a>

        <div class="dropdown-menu" aria-labelledby="moreMenuLink">
            @if (!$task->is_completed)
                <x-utils.form-button :action="route('frontend.tasks.mark-as-completed', $task)"
                    method="patch"
                    name="confirm-item"
                    button-class="dropdown-item"
                >
                    @lang('Mark as completed')
                </x-utils.form-button>
            @endif
        </div>
    </div>
@endif
