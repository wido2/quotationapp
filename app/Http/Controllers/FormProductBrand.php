<?php

namespace App\Http\Controllers;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class FormProductBrand extends Controller
{
    static function formProductBrand():array{
        return [
            TextInput::make('name')
                ->required()
                ->live(onBlur:true)
                ->afterStateUpdated(function (Set $set, $state) {
                    $set('slug', Str::slug($state));
                })
                ->maxLength(255),
                TextInput::make('slug')
                ->required()
                ->readOnly()
                ->maxLength(255),
                Textarea::make('description')
                ->required()
                ->columnSpanFull(),
                FileUpload::make('logo_path')
                ->directory('product_brands')
                ->disk('public')
                ,
                Toggle::make('is_active')
                ->label('Is Active?')
                ->required()
                ->default(true),
        ];
    }
}
