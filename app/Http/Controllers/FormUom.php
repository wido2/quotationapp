<?php

namespace App\Http\Controllers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Http\Request;

class FormUom extends Controller
{

 static function formUom(): array{
    return [
        TextInput::make('name')
        ->required()
        ->maxLength(50),
        Textarea::make('description')
        ->required()
        ->columnSpanFull(),
    ];
 }
}
