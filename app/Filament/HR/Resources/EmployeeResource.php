<?php

namespace App\Filament\HR\Resources;

use App\Filament\HR\Resources\EmployeeResource\Actions\CreateFinanceMovementAction;
use App\Filament\HR\Resources\EmployeeResource\Pages;
use App\Filament\HR\Resources\EmployeeResource\Pages\ViewEmployee;
use App\Filament\HR\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Funcionário';

    protected static ?string $pluralModelLabel = 'Funcionários';

    public static function form(Form $form): Form
    {
        return $form
        ->columns(3)
        ->schema([
            TextInput::make('name')
            ->label('Nome'),

            TextInput::make('cpf')
            ->label('CPF')
            ->mask('999.999.999-99')
            ->stripCharacters(['.', '-'])
            ->placeholder('000.000.000-00'),

            TextInput::make('salary')
            ->label('Salário')
            ->mask(RawJs::make('$money($input, \',\')'))
            ->inputMode('decimal')
            ->placeholder('0,00')
            ->stripCharacters([',','.'])
            ->numeric()
            ->prefix('R$'),

            Hidden::make('company_id')
            ->default(auth()->user()->company_id)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('name')
            ->label('Nome'),

            TextColumn::make('cpf')
            ->label('CPF')
            ->formatStateUsing(function ($state) {
                return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $state);
            }),

            TextColumn::make('salary')
            ->label('Salário')
            ->money('BRL', 100)
        ])
        ->recordUrl(function (Employee $employee) {
            return ViewEmployee::getUrl([$employee->id]);
        })
        ->filters([
            //
        ])
        ->actions([
            ActionGroup::make([
                Tables\Actions\EditAction::make(),

                CreateFinanceMovementAction::make('register_income')
                ->label('Registrar Entrada/Bônus')
                ->icon('heroicon-o-document-arrow-up'),
                
                CreateFinanceMovementAction::make('register_expense')
                ->label('Registrar Desconto')
                ->icon('heroicon-o-document-arrow-down')
                ->negative(),
            ])
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'show' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
