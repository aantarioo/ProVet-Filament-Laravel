<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->label('Describe your problem')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\Select::make('name_of_patient')
                    ->label('Patient')
                    ->options([
                        'cat' => 'Cat',
                        'dog' => 'Dog',
                        'rabbit' => 'Rabbit',
                        'bird' => 'Bird',
                        'rodent' => 'Rodent',
                        'reptile' => 'Reptile',
                    ])->required(),
                Forms\Components\DatePicker::make('date_of_appointment')->required()->minDate(now()),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                    ])->required(),
                Forms\Components\Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\TextColumn::make('description')->searchable(),
                    Tables\Columns\TextColumn::make('name_of_patient')->searchable(),
                    Tables\Columns\TextColumn::make('date_of_appointment')->icon('heroicon-m-calendar-days')->searchable()->sortable()->date(),
                    Tables\Columns\TextColumn::make('status')->searchable()
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending' => 'gray',
                            'confirmed' => 'warning',
                            'completed' => 'success',
                        })

                    ,
                    Tables\Columns\Layout\Panel::make([
                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\TextColumn::make('owner.name')->icon('heroicon-m-identification')->searchable(),
                            Tables\Columns\TextColumn::make('owner.email')->icon('heroicon-m-envelope'),
                            Tables\Columns\TextColumn::make('owner.phone')->icon('heroicon-m-phone'),
                        ])->alignment(Alignment::Center),
                    ]),
                ])
                    ->from('md'),
            ])->defaultGroup('status')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['doctor', 'super_admin']);
    }
}
