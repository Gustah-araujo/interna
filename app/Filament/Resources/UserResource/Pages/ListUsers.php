<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Role;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

// use Illuminate\Contracts\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make()
            ->label('Todos'),
        ];

        foreach (Role::get() as $role) {
            $tabs[$role->name] = Tab::make($role->name)
            ->label($role->name)
            ->modifyQueryUsing(function (Builder $query) use ($role) {
                $query->whereHas('roles', function (Builder $query) use ($role) {
                    $query->where('name', '=', $role->name);
                });
            });
        }

        return $tabs;
    }
}
