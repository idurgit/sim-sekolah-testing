<?php

namespace App\Livewire;

use App\Models\Student;

use Filament\Tables\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Livewire\Component;
use Filament\Tables\Table;
use App\Actions\EnrollStudent; // Assuming you have an EnrollAction class

class AvailableStudent extends Component implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    public $classroomId = null;

    protected $listeners = ['classroom-changed' => 'updateClassroom'];

    public function updateClassroom($classroomId)
    {
        $this->classroomId = $classroomId;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('age')
                    ->label('Age')
                    ->getStateUsing(fn($record) => \Carbon\Carbon::parse($record->date_of_birth)->age),
                TextColumn::make('sex'),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Parent'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('Enroll')
                    ->action(
                        function (Student $record) {
                            // Keep validation in the Livewire component
                            if (is_null($this->classroomId)) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('Please select a classroom first.')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            $enrollAction = new EnrollStudent();

                            // Check if the student is already enrolled in the classroom
                            if ($enrollAction->isAlreadyEnrolled($record->id, $this->classroomId)) {
                                Notification::make()
                                    ->title('Error')
                                    ->body('Student is already enrolled in this classroom.')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            // Process the enrollment
                            $enrollment = $enrollAction->handle($record, $this->classroomId);

                            // Emit an event when enrollment is successful
                            $this->dispatch('student-enrolled', studentId: $record->id);
                        }
                    )
                    ->tooltip(fn() => is_null($this->classroomId) ? 'Please select a classroom first.' : null)
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render()
    {
        return view('livewire.available-student');
    }
}
