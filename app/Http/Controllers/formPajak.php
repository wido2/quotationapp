<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class formPajak extends Controller
{
    public static function getFormPajak(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(50)->columnSpan(1),
            TextInput::make('rate')->required()->numeric()->maxValue(100),
            Textarea::make('description')->columnSpanFull()
        ];
    }
}
