<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersCount extends BaseWidget
{
    protected function getStats(): array
    {
        $usersCount = User::count();

        return [
            Stat::make('Usuários', $usersCount)
            ->chart([17, 5, 12, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
