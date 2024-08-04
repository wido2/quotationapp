<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Http\Controllers\formAddress;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Resources\RelationManagers\RelationManager;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema(
                formAddress::getFormAddress()
        );
    }


    public function table(Table $table): Table
    {
        return $table
            // ->recordUrl(null)
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('address')
                ->searchable(),
                TextColumn::make('city')
                ->searchable(),
                TextColumn::make('state')
                ->searchable(),
                TextColumn::make('country')
                ->searchable(),
                TextColumn::make('zip_code')
                ->searchable(),
                TextColumn::make('type')
                ->searchable(),
                ToggleColumn::make('is_default')
                ->label('Default'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    DeleteAction::make(),
                    EditAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


}
