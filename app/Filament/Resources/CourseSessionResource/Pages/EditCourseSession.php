<?php

namespace App\Filament\Resources\CourseSessionResource\Pages;

use App\Filament\Resources\CourseSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseSession extends EditRecord
{
    protected static string $resource = CourseSessionResource::class;

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
