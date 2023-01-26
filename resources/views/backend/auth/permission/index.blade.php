@extends('backend.layouts.app')

@section('title', __('Permission Management'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Permission Management')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.auth.permission.create')"
                :text="__('Create Permission')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.permissions-table />
        </x-slot>
    </x-backend.card>
@endsection
