<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OprekLokerProjectResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\OprekLokerProject;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class OprekLokerProjectResource extends Resource
{
    protected static ?string $model = OprekLokerProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'nama_project';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('thumbnail_oprek')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->columnSpan(2)
                    ->visibility('public'),

                TextInput::make('nama_project')
                    ->required()
                    ->maxLength(255),

                TextInput::make('penyelenggara')
                    ->required(),

                TextInput::make('tautan_oprek')
                    ->label('Tautan Event')
                    ->url()
                    ->required(),

                DatePicker::make('deadline_project')
                    ->required(),

                Textarea::make('deskripsi_project')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_oprek')
                    ->disk('public'),

                TextColumn::make('nama_project')
                    ->searchable(),

                TextColumn::make('penyelenggara'),

                TextColumn::make('tanggal_event')
                    ->date()
                    ->sortable(),

                TextColumn::make('tautan_oprek'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOprekLokerProjects::route('/'),
            'create' => Pages\CreateOprekLokerProject::route('/create'),
            'edit' => Pages\EditOprekLokerProject::route('/{record}/edit'),
        ];
    }
}
