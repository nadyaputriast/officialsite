<?php

namespace App\Filament\Resources\OprekLokerProjectResource\Pages;

use App\Filament\Resources\OprekLokerProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOprekLokerProject extends EditRecord
{
    protected static string $resource = OprekLokerProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
