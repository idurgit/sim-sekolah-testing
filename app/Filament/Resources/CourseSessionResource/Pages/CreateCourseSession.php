<?php

namespace App\Filament\Resources\CourseSessionResource\Pages;

use App\Filament\Resources\CourseSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

class CreateCourseSession extends CreateRecord
{
    protected static string $resource = CourseSessionResource::class;
    protected static bool $canCreateAnother = false;

    // Change this line from protected to protected static
    public static string|Alignment $formActionsAlignment = Alignment::End;

    //customize redirect after create
    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
