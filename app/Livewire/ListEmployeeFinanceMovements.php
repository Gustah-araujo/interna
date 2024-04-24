<?php

namespace App\Livewire;

use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ListEmployeeFinanceMovements extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public Employee $employee;

    public function table(Table $table): Table
    {
        return $table
        ->relationship(function () {
            return $this->employee->finance_movements();
        })
        ->heading('Movimentações Financeiras')
        ->columns([

            TextColumn::make('description')
            ->label('Descrição'),

            TextColumn::make('date')
            ->label('Data')
            ->formatStateUsing(function (Carbon $state) {
                return $state->format('d/m/Y');
            }),

            TextColumn::make('amount')
            ->label('Valor')
            ->money('BRL', 100)
            ->badge()
            ->color(function (int $state) {
                return $state > 0 ? 'success' : 'danger';
            })

        ])
        ->filters([
            Filter::make('date_range')
            ->form([

                DatePicker::make('start')->label('De:')
                ->native(false)
                ->displayFormat('d/m/Y'),

                DatePicker::make('end')->label('Até:')
                ->native(false)
                ->displayFormat('d/m/Y'),

            ])
            ->query(function (Builder $query, array $data) {
               return $query
               ->when($data['start'], function (Builder $query, $start_date) {
                    $query->where('date', '>=', $start_date);
                })
                ->when($data['end'], function (Builder $query, $end_date) {
                    $query->where('date', '<=', $end_date);
                });
            }),
        ]);
    }

    public function render()
    {
        return view('livewire.list-employee-finance-movements');
    }
}
