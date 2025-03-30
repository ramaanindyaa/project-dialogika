<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class CourseSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'courseSections';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('position')
                    ->required()
                    ->numeric()
                    ->prefix('Position'),

                Repeater::make('quizzes')
                    ->relationship('quizzes')
                    ->schema([
                        TextInput::make('title')->required(),
                        Select::make('type')
                            ->options([
                                'pre' => 'Pre-Section Quiz',
                                'post' => 'Post-Section Quiz',
                            ])
                            ->required(),
                        Repeater::make('questions')
                    ->relationship('questions')
                    ->schema([
                        TextInput::make('question')->required(),
                        TextInput::make('options')
                            ->required()
                            ->placeholder('Option1,Option2,Option3')
                            ->afterStateHydrated(function ($state, $set) {
                                // Pastikan data adalah array sebelum diolah
                                if (is_array($state)) {
                                    $set('options', implode(',', $state));
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // Ubah string ke array sebelum disimpan
                                return explode(',', $state);
                            }),
                        TextInput::make('correct_answer')->required(),
                    ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('position'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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
}
