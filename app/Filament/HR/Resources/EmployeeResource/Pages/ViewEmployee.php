<?php

namespace App\Filament\HR\Resources\EmployeeResource\Pages;

use App\Filament\HR\Resources\EmployeeResource;
use App\Livewire\ListEmployeeFinanceMovements;
use Filament\Actions;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewEmployee extends ViewRecord
{
    protected static string $resource = EmployeeResource::class;

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
                ->label('CPF'),

                TextEntry::make('salary')
                ->label('Salário')
                ->money('BRL', 100)
            ]),

            Livewire::make(ListEmployeeFinanceMovements::class, ['employee' => $this->getRecord()])
            ->columnSpanFull()
        ]);
    }
}
