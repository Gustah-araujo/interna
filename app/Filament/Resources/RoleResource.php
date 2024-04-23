<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Permission;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Função';

    protected static ?string $pluralModelLabel = 'Funções';


    public static function form(Form $form): Form
    {
        $permissions = Permission::get();

        $permissions = $permissions->groupBy('scope');

        $permissionsCheckboxes = [];

        foreach ($permissions as $scope => $scopePermissions) {
            $permissionsCheckboxes[] = CheckboxList::make("permissions.{$scope}")
            ->bulkToggleable()
            ->relationship('permissions')
            ->options(function () use ($scopePermissions) {
                $data = [];

                foreach ($scopePermissions as $scopePermission) {
                    $data[$scopePermission->id] = $scopePermission->description;
                }

                return $data;
            });
        }

        return $form
            ->schema([

                Section::make('Informação')
                ->schema([

                    TextInput::make('name')
                    ->label('Nome'),

                ]),

                Section::make('Permissões')
                ->schema($permissionsCheckboxes),

            ]
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                ->label('Nome'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]
        );
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
