@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Create Permission'))

@section('content')
    <x-forms.post :action="route('admin.auth.permission.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Permission')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.auth.permission.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                @include('backend.auth.permission.includes.form', ['permission' => $emptyPermission])
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Permission')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
