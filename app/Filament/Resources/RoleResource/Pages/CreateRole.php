<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = auth()->user()->company_id;

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $role = static::getModel()::create($data);

        foreach ($data['permissions'] as $scope => $permissions) {
            $role->permissions()->attach($permissions);
        }

        return $role;
    }
}
