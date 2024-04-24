<?php

namespace App\Filament\HR\Resources\EmployeeResource\Actions;

use App\Models\Employee;
use App\Models\EmployeeFinanceMovement;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;

class CreateFinanceMovementAction extends Action {

    private bool $negative = false;

    public function negative(bool $condition = true): static
    {
        if ($condition) {
            $this->negative = true;
        }

        return $this;
    }

    public static function make(?string $name = null): static
    {
        return parent::make($name)
        ->form([
            Section::make()
            ->columns(4)
            ->schema([
                TextInput::make('description')
                ->label('Descrição')
                ->columnSpan(2),
    
                TextInput::make('amount')
                ->label('Valor')
                ->mask(RawJs::make('$money($input, \',\')'))
                ->placeholder('0,00')
                ->stripCharacters([',','.'])
                ->numeric()
                ->prefix('R$'),
    
                DatePicker::make('date')
                ->label('Data')
                ->displayFormat('d/m/Y')
                ->closeOnDateSelection()
                ->native(false),

                Hidden::make('employee_id')
                ->default(function (Employee $record) {
                    return $record->id;
                }),
            ])
        ])
        ->action(function (CreateFinanceMovementAction $action, array $data) {
            if ($action->negative) {
                $data['amount'] = intval($data['amount']) * -1;
            }

            EmployeeFinanceMovement::create($data);
        })
        ->successNotification(
            Notification::make()
                 ->success()
                 ->title('Movimentação Registrada')
                 ->body('Movimentação/Bônus registrado(a) com sucesso.'),
        );
    }
}