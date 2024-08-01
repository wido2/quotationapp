<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pajak;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PajakResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PajakResource\RelationManagers;
use App\Http\Controllers\formPajak;

class PajakResource extends Resource
{
    protected static ?string $model = Pajak::class;
    protected static ?string $navigationLabel = 'Pajak';
    // protected static ?string $title = 'Custom Page Title';

    protected static ?string $navigationGroup  ='Setting';



    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
              formPajak::getFormPajak()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rate')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('description')
                    ->searchable()
                    ->sortable()
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPajaks::route('/'),
            'create' => Pages\CreatePajak::route('/create'),
            'edit' => Pages\EditPajak::route('/{record}/edit'),
        ];
    }
}
