<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Filament\Resources\Resource;
use App\Http\Controllers\FormUom;
use App\Http\Controllers\FormProduct;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\FormProductBrand;
use App\Http\Controllers\FormProductCategory;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Support\Enums\Alignment;
use Symfony\Polyfill\Intl\Idn\Idn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup  ='Product';

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    public static function form(Form $form): Form
    {

        return $form
            ->schema(
                FormProduct::formProduct()
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
                TextColumn::make('productBrand.name')
                ->searchable()
                ->alignment(Alignment::Center),
                TextColumn::make('productCategory.name'),
            //   TextColumn::make('uom.name')
            //   ->searchable(),
                TextColumn::make('price')
                ->money('IDR',locale:'id'),
                TextColumn::make('stock')
                ->searchable()
                ->sortable(),
                ToggleColumn::make('is_active')
                ->sortable(),
                TextColumn::make('created_at')
                ->toggleable(true),
                TextColumn::make('updated_at')
                ->toggleable()

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
