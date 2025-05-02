<?php

namespace App\Filament\Pages;

use App\Models\Assessment;
use App\Models\CourseSession;
use App\Models\Enrollment;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class AssessmentPage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.assessment-page';
    // add to navigation group
    protected static ?string $navigationGroup = 'Learning Activities';
    // navigation sorting
    protected static ?int $navigationSort = 2;
    // hide from navigation
    protected static bool $shouldRegisterNavigation = false;

    public $sessionId;
    public $classSession = null;

    public function mount(): void
    {
        $this->sessionId = request()->query('session_id');
        if ($this->sessionId) {
            $this->classSession = CourseSession::with(['course', 'classroom'])->find($this->sessionId);
            if (!$this->classSession) {
                Notification::make()
                    ->title('Course Session not found')
                    ->danger()
                    ->send();
            } else {
                // prefill Assessment data with available students from Enrollment table
                Enrollment::where('classroom_id', $this->classSession->classroom_id)
                    ->with(['student'])
                    ->get()
                    ->map(function ($enrollment) {
                        Assessment::firstOrCreate([
                            'course_session_id' => $this->sessionId,
                            'enrollment_id' => $enrollment->id,
                            // 'result' => null,
                        ],
                    );
                    });
        }
    }
}

    public function table(Table $table): Table 
    {
    if (!$this->sessionId || !$this->classSession) {
        //return empty table if no session is selected
        return $table->query(Assessment::where('id', 0));
    }

    // get the classroom ID from the course session
    $classroomId = $this->classSession->classroom_id;
    return $table
        ->query(Assessment::query()
            ->where('course_session_id', $this->sessionId)
            ->with(['enrollment.student'])
        )
        ->columns([
            TextColumn::make('enrollment.student.name')
                ->label('Student Name')
                ->sortable()
                ->searchable()
                ->toggleable(),
            TextInputColumn::make('result')
                ->label('Result')
                ->sortable()
                ->searchable()
                ->toggleable(),
        ])->headerActions([
            // You can add header actions here if needed
        ])
        ->filters([
            // You can add filters here if needed
        ])
        ->actions([
            // You can add actions here if needed
        ])
        ->bulkActions([
            // You can add bulk actions here if needed
        ]);
    }
    
}