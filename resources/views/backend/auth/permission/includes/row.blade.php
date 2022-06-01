<x-livewire-tables::bs4.table.cell>
    {{ $row->type }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {{ $row->name }}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    {!! $row->description !!}
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    @if ($row->parent)
        {{ $row->parent->name }}
    @endif
</x-livewire-tables::bs4.table.cell>

<x-livewire-tables::bs4.table.cell>
    @include('backend.auth.permission.includes.actions', ['model' => $row])
</x-livewire-tables::bs4.table.cell>
