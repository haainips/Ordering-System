<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers;
use App\Models\Kategori;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationLabel = 'Menu';
protected static ?string $pluralLabel = 'Daftar Menu';   
    protected static ?int $navigationSort = 2; 
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_kategori')
                ->label('Kategori')
                ->options(Kategori::all()->pluck('nama', 'id'))
                ->required()
                ->searchable(),
                TextInput::make('nama_menu')
                ->required()
                ->label('Menu'),
                FileUpload::make('gambar')
                ->disk('public')
                ->imageEditor()
                ->imageEditorAspectRatios([
                    '1:1',
                ]),                    
                TextInput::make('harga')
                ->label('Harga')
                ->required()
                ->numeric(),
                Select::make('status')
                ->options([
                    'Ready' => 'Ready',
                    'Kosong' => 'Kosong'
                ])
                ->required(),
                Select::make('jenis')
                ->options([
                    'Minuman' => 'Minuman',
                    'Makanan' => 'Makanan'
                ])
                ->required(),
                
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('kategori.nama')
                ->label('Kategori'),
                TextColumn::make('nama_menu')
                ->label('Menu'),
                ImageColumn::make('gambar')
                ->disk('public')
                ->label('Gambar')
                ->size(100),
                TextColumn::make('harga')
                ->label('Harga')
                ->money('idr', true)
                ->formatStateUsing(function ($state) {
                        return 'Rp ' . number_format($state, 0, ',', '.');
                    }),
                TextColumn::make('status')
                ->label('Status Menu'),
                TextColumn::make('jenis')
                ->label('Jenis'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
