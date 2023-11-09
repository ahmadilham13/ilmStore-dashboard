<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BooleanColumn;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationGroup = 'Shop';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General')
                    ->description('this is description')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                ->disabled()
                            ]),
                            Textarea::make('description')
                            ->autosize()
                            ->rows(10),
                    ])
                    ->aside(),
                Section::make('Specific')
                    ->description('this is description')
                    ->schema([
                        Select::make('category_id')
                        ->required()
                        ->relationship('category', 'name'),
                        FileUpload::make('images')
                        ->required()
                        ->imageEditor()
                        ->imageEditorAspectRatios([null, '16:9', '1:1']),
                        FileUpload::make('gallery')
                        ->imageEditor()
                        ->imageEditorAspectRatios([null, '16:9', '1:1'])
                        ->multiple(),
                    ])
                    ->aside(),
                
                Section::make('Pricing')
                    ->description('this is description')
                    ->schema([
                        TextInput::make('price')
                        ->numeric()
                        ->minValue(0),
                        Checkbox::make('available')
                        ->live(),

                        TextInput::make('stock')
                        ->numeric()
                        ->minValue(0)
                        ->hidden(fn (Get $get): bool => ! $get('available')),
                    ])
                    ->aside()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                ->square()
                ->defaultImageUrl(url('https://dfstudio-d420.kxcdn.com/wordpress/wp-content/uploads/2019/06/digital_camera_photo-1080x675.jpg')),
                TextColumn::make('name'),
                TextColumn::make('price')->money('idr'),
                BooleanColumn::make('available'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
