<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\RelationManagers\AddressRelationManager;
use Carbon\Carbon;
use App\Models\Uom;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use function Laravel\Prompts\text;
use Symfony\Polyfill\Intl\Idn\Idn;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderNumber;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager as RelationManagersAddressRelationManager;
use App\Http\Controllers\getDeliveryAddress;
use App\Models\Address;
use App\Models\Pajak;
use Closure;
use Filament\Forms\Components\Tabs;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup  ='Sales Order';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Sales Order Information')
                        ->columns(2)
                        ->schema([

                            ToggleButtons::make('status')
                            ->options([
                                'draft'=>'Draft',
                                'confirmed'=>'Confirmed',
                                'canclled'=>'Cancelled'
                                ])
                            ->inline()
                            ->default('draft'),
                            TextInput::make('order_no')
                            ->required()
                            ->label('Order Number')
                            ->readOnly()
                            ->default(
                                OrderNumber::generate(Order::count() + 1)
                            )
                            ->maxLength(50),
                            Select::make('customer_id')
                            ->relationship('customer','name')
                            ->preload()
                            ->searchable()
                            ->required(),
                            DatePicker::make('expiration')
                            ->required()
                            ->label('Quotation Expired')
                            ->default(Carbon::now()->addDays(14))
                            ->format('Y/m/d'),

                            Select::make('payment_term_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('paymentTerm','name')
                            ->required(),
                            Select::make('user_id')
                            ->required()
                            ->default(Auth::user()->id)
                            ->preload()
                            ->searchable()
                            ->relationship('user','name'),
                        ]),
                    Tabs\Tab::make('Address Information')
                        ->schema([
                            Select::make('delivery_address')
                            // ->reactive()
                            ->getSearchResultsUsing(fn (Get $get):array=>
                                Address::where('customer_id','like',$get ('customer_id'))
                                ->where('type','=','Delivery Address')
                                   ->pluck('address','address')
                                    ->toArray())
                            ->preload()
                            ->searchable()
                            ->required(),
                            Select::make('invoice_address')
                            // ->reactive()
                            ->getSearchResultsUsing(fn (Get $get):array=>
                                Address::where('customer_id','like',$get ('customer_id'))
                                ->where('type','=','Invoice Address')
                                   ->pluck('address','address')
                                    ->toArray())
                            ->preload()
                            ->searchable()
                            ->required(),


                        ]),

                    ])->columnSpanFull(),









                Section::make('Order Items')
                ->schema([
                    Repeater::make('orderItems')
                    ->relationship()
                    ->label('Order Items Detail')
                    ->schema([
                        Grid::make(8)
                        ->schema([
                            Select::make('product_id')
                            ->relationship('product','name')
                            ->preload()
                            ->placeholder('Nama Produk')
                            ->searchable()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->columnSpan(2)
                            ->reactive()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $set('uom_id', Product::find($get('product_id'))->uom_id);
                            })
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $set('pajak_id', Product::find($get('product_id'))->pajak_id);
                            })

                            ->afterStateUpdated(

                                function (Set $set, $state){
                                    $set('unit_price',Product::find($state)->price??'select product');
                                })
                                ->afterStateUpdated(
                                    fn ($state,Set $set) => $set('total_price',Product::find($state)->price??'Select Product')
                                )

                            ->required(),

                           Select::make('uom_id')

                           ->relationship('uom','name'),

                            TextInput::make('quantity')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated (
                                fn ($state, Set $set, Get $get) => $set('total_price', $state * $get('unit_price'))
                                )
                            ->minValue(1)
                            ->columnSpan(1)
                            ->required(),
                            TextInput::make('unit_price')
                            ->numeric()
                            ->currencyMask()
                            ->minValue(0)
                            ->readOnly()
                            ->required()

                            ->columnSpan(1),
                            TextInput::make('total_price')
                            ->readOnly()
                            ->columnSpan(1)
                            ->numeric()
                            ->currencyMask()
                            ->minValue(0)
                            ->required(),
                            Select::make('pajak_id')
                            ->placeholder('PPN')
                            ->relationship('pajak','name')
                            ->columnSpan(1)
                            ->searchable()
                            ->preload()
                            ->required(),
                            TextInput::make('discount')
                            ->columnSpan(1)
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->required()

                        ])

                        ]),
                        Placeholder::make('total_order')
                        ->label(' Total')

                        ->content(
                            function (Get $get, Set $set) {
                                $total = 0;
                                if (!($repeaters = $get('orderItems'))) {
                                    return $total;
                                }else $total;
                                foreach ($repeaters as $key => $repeater) {
                                    $total += $get("orderItems.{$key}.total_price");
                                }
                                $set('total_order', $total);
                                return Number::currency($total, 'IDR');
                            }
                        ),
                        Placeholder::make('grand_total')
                        ->label('Grand Total')
                        ->content(
                            function (Get $get,Set $set) {
                                $grand_total = 0;
                                $total = $get('total_order');

                                if (!($repeaters = $get('orderItems'))) {
                                    return $grand_total;
                                }

                                foreach ($repeaters as $key => $repeater) {
                                    $pajak_id = $repeater['pajak_id'];
                                    if ($pajak_id) {
                                        $pajak = Pajak::find($pajak_id);
                                        $tax = $repeater['total_price'] * ($pajak->rate / 100);
                                        $grand_total += $repeater['total_price'] + $tax;
                                    } else {
                                        $grand_total += $repeater['total_price'];
                                    }
                                    $set('grand_total',$grand_total);
                                }

                                return Number::currency($grand_total, 'IDR');
                            }
    ),


                        Hidden::make('grand_total')
                        ->default(0)                ,
                    Textarea::make('note')
                    ->required()
                    ->columnSpanFull(),
                ])
            ]);
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
