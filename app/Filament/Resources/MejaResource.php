<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MejaResource\Pages;
use App\Filament\Resources\MejaResource\RelationManagers;
use App\Models\Meja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MejaResource extends Resource
{
    protected static ?string $model = Meja::class;
    protected static ?string $navigationLabel = 'Meja';
    protected static ?string $pluralLabel = 'Daftar Meja';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListMejas::route('/'),
            'create' => Pages\CreateMeja::route('/create'),
            'edit' => Pages\EditMeja::route('/{record}/edit'),
        ];
    }
}
