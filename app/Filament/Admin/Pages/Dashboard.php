<?php
 
namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\UsersCount;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getWidgets(): array
    {
        return [
            UsersCount::make()
        ];
    }
}