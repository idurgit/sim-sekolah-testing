<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSessionResource\Pages;
use App\Filament\Resources\CourseSessionResource\RelationManagers;
use App\Models\Classroom;
use App\Models\CourseSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseSessionResource extends Resource
{
    protected static ?string $model = CourseSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    // add to learning activities
    protected static ?string $navigationGroup = 'Learning Activities';
    protected static ?string $navigationLabel = 'Course Sessions';
    // add navigation sorting
    protected static ?int $navigationSort = 1;
    // get model label
    public static function getModelLabel(): string
    {
        return 'Course Session';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Remove the outer Grid component and place sections directly in a row
                Forms\Components\Section::make('Course and Classroom Details')
                    ->columnSpan(['lg' => 1]) // Take up 1 of 2 columns on large screens
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('classroom_id')
                            ->relationship('classroom', 'name')
                            ->options(Classroom::with(['level', 'academicYear'])->get()->mapWithKeys(function ($classroom) {
                                return [
                                    $classroom->id => "{$classroom->level->name} {$classroom->name} ({$classroom->academicYear->year})"
                                ];
                            }))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                    
                Forms\Components\Section::make('Course Session Details')
                    ->columnSpan(['lg' => 1]) // Take up 1 of 2 columns on large screens
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Learning Topics')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('session_date')
                            ->label('Session Date')
                            ->placeholder('Select date')
                            ->required(),
                        Forms\Components\RichEditor::make('session_note')
                            ->label('Session Note')
                            ->placeholder('Enter session note')
                            ->required()
                            ->maxLength(255), 
                    ]),
            ])
            ->columns(2); // Set the form to have 2 columns
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->html(),
                Tables\Columns\TextColumn::make('session_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_note')
                    ->html(),
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->label('Classroom')
                    ->formatStateUsing(function ($record) {
                        return "{$record->classroom->level->name} - {$record->classroom->name} - {$record->classroom->academicYear->year}";
                    })
                    ->sortable(),
            ])
            ->filters([], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // add custom action to go to AssessmentPage
                Tables\Actions\Action::make('Go to Assessment')
                    ->url(fn (CourseSession $record): string => url('/assessment-page?session_id=' . $record->id))
                    ->icon('heroicon-o-arrow-right')
                    ->color('success'),
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
            'index' => Pages\ListCourseSessions::route('/'),
            'create' => Pages\CreateCourseSession::route('/create'),
            'edit' => Pages\EditCourseSession::route('/{record}/edit'),
        ];
    }
}
