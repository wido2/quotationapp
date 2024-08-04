<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Http\Controllers\formOrder;
use Filament\Support\Enums\Alignment;

use Filament\Tables\Columns\TextColumn;


use App\Filament\Resources\OrderResource\Pages;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup  ='Sales Order';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                formOrder::getOrderForm()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_no')
                ->searchable()
                ->sortable(),

                TextColumn::make('customer.name')
                ->searchable()
                ->sortable(),
                TextColumn::make('expiration')
                ->sortable(),

                TextColumn::make('paymentTerm.name')
                ->searchable()
                ->alignment(Alignment::Center)
                ->sortable(),
                TextColumn::make('user.name')
                ->searchable()
                ->alignment(Alignment::Center)
                ->sortable(),
                TextColumn::make('grand_total')
                ->sortable()
                ->money('IDR',0,locale:'id'),
                TextColumn::make('note')
                ->sortable(),
                TextColumn::make('status')
                ->sortable(),



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
            // RelationManagersAddressRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
