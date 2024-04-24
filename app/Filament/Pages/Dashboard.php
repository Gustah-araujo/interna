<?php
 
namespace App\Filament\Pages;

use App\Filament\Widgets\UsersCount;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            UsersCount::make()
        ];
    }
}