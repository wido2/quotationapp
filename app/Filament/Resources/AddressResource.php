<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;

use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AddressResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AddressResource\RelationManagers;
use Filament\Forms\Components\ToggleButtons;

class AddressResource extends Resource
{
    protected static ?string $model = Address::class;
    protected static ?string $navigationGroup  ='Customer';

    protected static ?string $navigationIcon = 'heroicon-o-map';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('customer_id')
                ->required()
                ->preload()
                ->searchable( )
                ->relationship('customer','name'),
                TextInput::make('address')
                ->required()
                ->label('Address ')
                ->maxLength(255),
                TextInput::make('city')
                ->label('City')
                ->required(),
                TextInput::make('state')
                ->label('State')
                ->required(),
                TextInput::make('country')
                ->label('Country')
                ->required(),
                TextInput::make('zip_code')
                ->label('Zip Code')
                ->maxLength(7)
                ->required(),
                ToggleButtons::make('type')
                ->options([
                    'Home' => 'Home',
                    'Office' => 'Office',
                    'Work' => 'Work',
                ])
                ->required()
                ->default('Office')
                ->icons([
                    'Home' => 'heroicon-o-home',
                    'Office' => 'heroicon-o-building-office',
                    'Work' => 'heroicon-o-briefcase',
                ])
                ->colors([
                    'Home' => 'primary',
                    'Office' => 'success',
                    'Work' => 'warning',
                ])
                ->inline(),
                Toggle::make('is_default')
                ->label('Is Default?')
                ->required()
                ->default(false),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('address')
                ->searchable()
                ->limit(15)
                ->sortable(),
                TextColumn::make('city')
                ->searchable()
                ->sortable(),
                TextColumn::make('state')
                ->searchable()
                ->sortable(),
                TextColumn::make('country')
                ->searchable()
                ->sortable(),
                TextColumn::make('zip_code')
                ->searchable()
                ->sortable(),
                ToggleColumn::make('is_default')
                ->label('Default'),

            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    DeleteAction::make(),
                    EditAction::make(),
                    ViewAction::make(),
                ])
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
