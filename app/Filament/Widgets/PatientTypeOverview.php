<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected ?string $heading = 'Number of patients';

    protected function getStats(): array
    {
        return [
            Stat::make('Cats', Patient::query()->where('type', 'cat')->count()),
            Stat::make('Dogs', Patient::query()->where('type', 'dog')->count()),
            Stat::make('Rabbits', Patient::query()->where('type', 'rabbit')->count()),
            Stat::make('Birds', Patient::query()->where('type', 'bird')->count()),
            Stat::make('Rodents', Patient::query()->where('type', 'rodent')->count()),
            Stat::make('Reptiles', Patient::query()->where('type', 'reptile')->count())
        ];
    }

}
