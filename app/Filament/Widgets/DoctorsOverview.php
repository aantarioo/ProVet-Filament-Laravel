<?php

namespace App\Filament\Widgets;

use App\Models\Owner;
use App\Models\User;
use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DoctorsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Doctors', Owner::query()->count())->icon('heroicon-o-identification'),
            Stat::make('Users', User::query()->count())->icon('heroicon-o-users'),
            Stat::make('Appointments', Appointment::query()->count())->icon('heroicon-o-pencil'),
        ];
    }
}
