@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('My Task')
                        <a href="{{ route('frontend.tasks.create') }}" class='btn btn-sm btn-primary float-right'>@lang('Create Task')</a>
                    </x-slot>

                    <x-slot name="body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered mb-0">
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th style="width: 25%">@lang('Description')</th>
                                    <th>@lang('Deadline At')</th>
                                    <th>@lang('Is Completed')</th>
                                    <th style="min-width: 1%; white-space: nowrap;">@lang('Actions')</th>
                                </tr>

                                @foreach ($tasks as $task)
                                    <tr>
                                        <th>{{ $task->title }}</th>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->deadline_at ?: __('N/A') }}</td>
                                        <td>{{ $task->is_completed ? __('Yes') : __('No') }}</td>
                                        <td>
                                            @include('frontend.task.includes.actions')
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div><!--table-responsive-->
                    </x-slot>

                    <x-slot name="footer">
                        {{ $tasks->links() }}
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
