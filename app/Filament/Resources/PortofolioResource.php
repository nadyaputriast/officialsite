<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortofolioResource\Pages;
use App\Models\Portofolio;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BooleanColumn;

class PortofolioResource extends Resource
{
    protected static ?string $model = Portofolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('nama_portofolio')
                    ->required(),
                Select::make('kategori_portofolio')
                    ->required()
                    ->multiple()
                    ->options([
                        'UI/UX Design' => 'UI/UX Design',
                        'Website Development' => 'Website Development',
                        'Mobile Development' => 'Mobile Development',
                        'Game Development' => 'Game Development',
                        'Internet of Things' => 'Internet of Things',
                        'Machine Learning' => 'Machine Learning',
                        'Data' => 'Data',
                    ]),
                Textarea::make('deskripsi_portofolio')
                    ->required(),
                TextInput::make('tautan_portofolio')
                    ->url()
                    ->required(),
                FileUpload::make('gambar_portofolio')
                    ->image()
                    ->multiple()
                    ->required()
                    ->disk('public')
                    ->directory('portofolio')
                    ->columnSpan(2)
                    ->visibility('public'),
                Toggle::make('status_portofolio')
                    ->label(fn($state): string => $state ? 'Valid' : 'Belum Valid')
                    ->live()
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline()
                    ->default(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_portofolio')
                    ->label('Nama Portofolio'),
                TextColumn::make('deskripsi_portofolio')
                    ->label('Deskripsi'),
                TextColumn::make('tautan_portofolio')
                    ->label('Tautan Portofolio'),
                ImageColumn::make('gambar_portofolio')
                    ->label('Gambar')
                    ->disk('public')
                    ->getStateUsing(fn($record) => is_array($record->gambar_portofolio) ? $record->gambar_portofolio[0] : $record->gambar_portofolio),
                TextColumn::make('kategori_portofolio')
                    ->label('Kategori')
                    ->getStateUsing(fn($record) => is_array($record->kategori_portofolio) ? implode(', ', $record->kategori_portofolio) : $record->kategori_portofolio),
                BooleanColumn::make('status_portofolio')
                    ->label('Validasi'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortofolios::route('/'),
            'create' => Pages\CreatePortofolio::route('/create'),
            'edit' => Pages\EditPortofolio::route('/{record}/edit'),
        ];
    }
}
