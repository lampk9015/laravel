<?php

namespace App\Http\Livewire\Backend;

use App\Domains\Auth\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Class PermissionsTable.
 */
class PermissionsTable extends DataTableComponent
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Permission::when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function columns(): array
    {
        return [
            Column::make(__('Type'))
                ->sortable(),
            Column::make(__('Name'))
                ->sortable(),
            Column::make(__('Description')),
            Column::make(__('Parent'))
                ->sortable(),
            Column::make(__('Actions')),
        ];
    }

    public function rowView(): string
    {
        return 'backend.auth.permission.includes.row';
    }
}
