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
    public function builder(): Builder
    {
        return Permission::query()
            ->select('parent_id')
            ->when($this->getFilter('search'), fn ($query, $term) => $query->search($term));
    }

    public function getFilter($column): bool
    {
        return ! (empty($this->columnSearch[$column] ?? null));
    }

    public function columns(): array
    {
        return [
            Column::make(__('Type'))
                ->sortable(),
            Column::make(__('Name'))
                ->sortable(),
            Column::make(__('Description')),
            Column::make(__('Parent Name'))
                ->label(fn ($row) => $row->parent_name)
                ->sortable(), // Can not sortable this column
            Column::make(__('Actions'), 'id')->format(
                fn ($value, $row, Column $column) => view('backend.auth.permission.includes.actions')->withModel($row)
            )->html(),
        ];
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }
}
