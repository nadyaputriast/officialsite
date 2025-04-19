<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use App\Models\EventRegistration;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'nama_event';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('thumbnail_event')
                    ->image()
                    ->required()
                    ->disk('public')
                    ->directory('thumbnails')
                    ->columnSpan(2)
                    ->visibility('public'),

                TextInput::make('nama_event')
                    ->required()
                    ->maxLength(255),

                Select::make('jenis_event')
                    ->required()
                    ->options([
                        'seminar' => 'Seminar',
                        'workshop' => 'Workshop',
                        'bootcamp' => 'Bootcamp',
                        'pameran' => 'Pameran',
                        'konferensi' => 'Konferensi',
                    ]),

                DatePicker::make('tanggal_event')
                    ->required(),

                TimePicker::make('waktu_event')
                    ->required(),

                Textarea::make('deskripsi_event')
                    ->required()
                    ->columnSpan(2),

                TextInput::make('nama_penyelenggara')
                    ->required()
                    ->maxLength(255),

                Select::make('penyelenggara_event')
                    ->required()
                    ->options([
                        'internal' => 'Internal',
                        'eksternal' => 'Eksternal',
                    ])
                    ->reactive(),

                TextInput::make('tautan_event')
                    ->label('Tautan Event')
                    ->url()
                    ->required(fn(Get $get) => $get('penyelenggara_event') === 'eksternal')
                    ->visible(fn(Get $get) => $get('penyelenggara_event') === 'eksternal'),

                TextInput::make('kuota_event')
                    ->numeric()
                    ->minValue(1)
                    ->default(10)
                    ->required(fn(Get $get) => $get('penyelenggara_event') === 'internal')
                    ->visible(fn(Get $get) => $get('penyelenggara_event') === 'internal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_event')
                    ->disk('public'),

                TextColumn::make('nama_event')
                    ->searchable(),

                TextColumn::make('jenis_event'),

                TextColumn::make('tanggal_event')
                    ->date()
                    ->sortable(),

                TextColumn::make('penyelenggara_event'),

                TextColumn::make('nama_penyelenggara'),

                TextColumn::make('tautan_event'),

                TextColumn::make('kuota_event'),

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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
