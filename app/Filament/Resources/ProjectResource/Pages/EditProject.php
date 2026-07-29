<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Support\Projects\ProjectFormData;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return app(ProjectFormData::class)->hydrate($this->record, $data);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return app(ProjectFormData::class)->dehydrate($data, $this->record);
    }
}
