<?php

namespace App\Filament\Resources\BookResource\Pages;

use App\Filament\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBook extends EditRecord
{
    protected static string $resource = BookResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
