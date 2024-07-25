<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\ProductBrand;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductBrandResource\Pages;
use App\Filament\Resources\ProductBrandResource\RelationManagers;
use App\Http\Controllers\FormProductBrand;
use Filament\Forms\Components\Textarea;

class ProductBrandResource extends Resource
{
    protected static ?string $model = ProductBrand::class;
    protected static ?string $navigationGroup  ='Product';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                FormProductBrand::formProductBrand()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),
                TextColumn::make('slug')
                ->searchable()
                ->sortable(),
                ToggleColumn::make('is_active')
                ->label('Active'),
                ImageColumn::make('logo_path')
                    ->label('Logo')

                    ->width(50)
                    ->height(50),
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
            'index' => Pages\ListProductBrands::route('/'),
            'create' => Pages\CreateProductBrand::route('/create'),
            'edit' => Pages\EditProductBrand::route('/{record}/edit'),
        ];
    }
}
