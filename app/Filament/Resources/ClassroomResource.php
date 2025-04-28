<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Models\Classroom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Layout;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Academic Settings';
    // navigation sort
    protected static ?int $navigationSort = 3;
    // get model label
    public static function getModelLabel(): string
    {
        return 'Classroom';
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Classroom Details')
                    ->schema([
                        Forms\Components\Select::make('academic_year_id')
                            ->relationship('academicYear', 'year')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('level_id')
                            ->relationship('level', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                            Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique('classrooms', 'name',ignoreRecord: true)
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Classroom Name')
                    ->getStateUsing(fn($record) => "{$record->level->name} - {$record->name} ({$record->academicYear->year})"),
                    
                Tables\Columns\TextColumn::make('academicYear.year')
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->placeholder('Search by name'),
            ])
            ->query(fn (Builder $query, array $data): Builder => $query
                ->where('name', 'like', "%{$data['name']}%")),
            // add filter for academic year
            Tables\Filters\SelectFilter::make('Academic_Year_id')
                ->relationship('academicYear', 'year')
                ->multiple()
                ->preload()
                ->placeholder('Select Academic Year'),    
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListClassrooms::route('/'),
            'create' => Pages\CreateClassroom::route('/create'),
            'edit' => Pages\EditClassroom::route('/{record}/edit'),
        ];
    }
}
