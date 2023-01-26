@inject('model', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Update Permission'))

@section('content')
    <x-forms.patch :action="route('admin.auth.permission.update', $permission)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Permission')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.auth.permission.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                @include('backend.auth.permission.includes.form', ['permission' => $permission])
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Permission')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
