<?php
namespace App\Filament\Pages;

use Illuminate\Support\Facades\DB; // Correct import

use App\Models\Classroom;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;

class Enrollment extends Page
{
    use InteractsWithForms;
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.enrollment';
    // add to navigation group academic settings
    protected static ?string $navigationGroup = 'Academic Settings';
    // add to navigation label
    protected static ?string $navigationLabel = 'Enrollment';
    // add to navigation sort
    protected static ?int $navigationSort = 6;

    public $data = [];
    public $classroomId = null;

    public function mount()
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('classroom_id')
                ->label('Select Classroom')
                ->options(Classroom::with(['level', 'academicYear'])->get()->mapWithKeys(function ($classroom) {
                    return [$classroom->id => "{$classroom->level->name} {$classroom->name} ({$classroom->academicYear->year})"];
                }))
                ->placeholder('Select a classroom')
                ->searchable()
                ->getSearchResultsUsing(function (string $query) {
                    return DB::table('classrooms')
                        ->join('levels', 'classrooms.level_id', '=', 'levels.id')
                        ->join('academic_years', 'classrooms.academic_year_id', '=', 'academic_years.id')
                        ->where(function ($queryBuilder) use ($query) {
                            $queryBuilder->where('levels.name', 'like', "%{$query}%")
                                ->orWhere('classrooms.name', 'like', "%{$query}%")
                                ->orWhere('academic_years.year', 'like', "%{$query}%");
                        })
                        ->select('classrooms.id', DB::raw("CONCAT(levels.name, ' ', classrooms.name, ' (', academic_years.year, ')') as display_name"))
                        ->get()
                        ->pluck('display_name', 'id');
                })
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state) {
                    $this->classroomId = $state;
                    $this->dispatch('classroom-changed', classroomId: $state);
                })
               ->columnSpanFull(),
        ];
    }

    public function getFormStatePath(): string
    {
        return 'data';
    }
}


