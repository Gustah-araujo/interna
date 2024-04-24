<?php

namespace App\Filament\HR\Resources\EmployeeResource\Pages;

use App\Filament\HR\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    // public function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['cpf'] = preg_replace('/\D/', '', $data['cpf']);

    //     return $data;
    // }
}
