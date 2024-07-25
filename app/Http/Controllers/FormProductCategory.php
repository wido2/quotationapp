<?php

namespace App\Http\Controllers;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class FormProductCategory extends Controller
{
    //

    static function getForm(): array{
        return [
        TextInput::make('name')
        ->required()
        ->maxLength(50)
        ->live(onBlur:true)
        ->afterStateUpdated(
            function (Set $set , $state){
                $set('slug', Str::slug($state));
            }
        ),
        TextInput::make('slug')
        ->required()
        ->readOnly(),
        Textarea::make('description')
        ->required()
        ->columnSpanFull(),
        Toggle::make('is_active')
        ->default(true),

        ];
    }
}
