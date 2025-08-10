<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $heading = 'Read before use';
    protected function getStats(): array
    {

        return [
            Stat::make('', 'Important')
                ->description('The clinic’s panel is an internal interface for veterinary staff. Through this panel, doctors and administrators can:

Manage patient data (animals) — add, edit, and view medical histories.

Track treatments and procedures for each pet.

Manage users and their roles (e.g., doctor, administrator).

This panel helps organize clinic operations efficiently, ensuring quality care for animals and smooth communication with clients.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('', 'Errors or bugs')
                ->description('If you encounter any errors or bugs while using the site, please let us know.
This will help us fix issues faster and improve the clinic’s service for everyone.

You can contact us via email at support@vetclinic.com or through the feedback form on the website.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('', 'Tips for use')
                ->description('To get the most out of the clinic panel, regularly update patient data. Use filters to quickly find specific animals and track their progress over time. Always log out after your session to keep the system secure.')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
        ];
    }
}
