@extends('frontend.layouts.app')

@section('title', __('Create Task'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Create Task')
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.tasks.store')">
                            @include('frontend.task.includes.form', [
                                'submitBtnLabel' => __('Create')
                            ])
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection

@include('frontend.task.includes.datetimepicker')
