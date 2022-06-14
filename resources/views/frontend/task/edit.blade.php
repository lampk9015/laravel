@extends('frontend.layouts.app')

@section('title', __('Edit Task'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Edit Task')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.patch :action="route('frontend.tasks.update', $task)">
                            @include('frontend.task.includes.form', [
                                'submitBtnLabel' => __('Update')
                            ])
                        </x-forms.patch>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection

@include('frontend.task.includes.datetimepicker')
