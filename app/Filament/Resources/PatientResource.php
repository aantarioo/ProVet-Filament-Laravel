<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Filament\Resources\PatientResource\RelationManagers;
use App\Models\Patient;
use Filament\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\Alignment;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    public static function form(Form $form): Form
    {


        return $form

            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                       'cat' => 'Cat',
                       'dog' => 'Dog',
                       'rabbit' => 'Rabbit',
                       'bird' => 'Bird',
                       'rodent' => 'Rodent',
                       'reptile' => 'Reptile',
                    ])->required(),
                Forms\Components\DatePicker::make('date_of_birth')->required()->maxDate(now()),
                Forms\Components\Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')->required()->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone number')
                            ->tel()
                            ->required(),
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\TextColumn::make('name')->searchable(),
                    Tables\Columns\TextColumn::make('type')->searchable(),
                    Tables\Columns\TextColumn::make('date_of_birth')->icon('heroicon-m-calendar-days')->searchable()->sortable()->date(),
                    Tables\Columns\Layout\Panel::make([
                            Tables\Columns\Layout\Stack::make([
                                Tables\Columns\TextColumn::make('owner.name')->icon('heroicon-m-identification')->searchable(),
                                Tables\Columns\TextColumn::make('owner.email')->icon('heroicon-m-envelope'),
                                Tables\Columns\TextColumn::make('owner.phone')->icon('heroicon-m-phone'),
                        ])->alignment(Alignment::Center),
                    ]),
                ])
                    ->from('md'),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                       'cat' => 'Cat',
                       'dog' => 'Dog',
                       'rabbit' => 'Rabbit',
                       'bird' => 'Bird',
                       'rodent' => 'Rodent',
                       'reptile' => 'Reptile'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make(),
                ]),
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
            RelationManagers\TreatmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }

    protected static ?string $navigationBadgeTooltip = 'The number of patients';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole(['doctor', 'super_admin']);
    }
}
