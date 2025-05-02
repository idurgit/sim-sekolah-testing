<?php

namespace App\Filament\Resources\CourseSessionResource\Pages;

use App\Filament\Resources\CourseSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseSessions extends ListRecords
{
    protected static string $resource = CourseSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
