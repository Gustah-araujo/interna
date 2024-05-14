<?php

namespace App\Filament\HR\Resources\EmployeeResource\Pages;

use App\Filament\HR\Resources\EmployeeResource;
use App\Livewire\ListEmployeeFinanceMovements;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

    public function getTitle(): string | Htmlable
    {
        return $this->record->name;
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('test')
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            Section::make('Informações')
            ->columns(3)
            ->schema([
                TextEntry::make('name')
                ->label('Nome'),

                TextEntry::make('cpf')
                ->label('CPF')
                ->formatStateUsing(function ($state) {
                    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $state);
                }),

                TextEntry::make('salary')
                ->label('Salário')
                ->money('BRL', 100)
            ]),

            Livewire::make(ListEmployeeFinanceMovements::class, ['employee' => $this->getRecord()])
            ->columnSpanFull()
        ]);
    }
}
