<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionContentResource\Pages;
use App\Filament\Resources\SectionContentResource\RelationManagers;
use App\Models\SectionContent;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionContentResource extends Resource
{
    protected static ?string $model = SectionContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-tablet';

    protected static ?string $navigationGroup = 'Products';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('course_section_id')
                ->label('Course Section')
                ->options(function () {
                    return \App\Models\CourseSection::with('course')
                        ->get()
                        ->mapWithKeys(function ($section) {
                            return [
                                $section->id => $section->course
                                    ? "{$section->course->name} - {$section->name}"
                                    : $section->name, // Fallback if course is null
                            ];
                        })
                        ->toArray(); // Convert the collection to an array
                })
                ->searchable()
                ->required(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Select::make('type') // Tambahkan ini
                    ->label('Content Type')
                    ->options([
                        'text' => 'Text',
                        'video' => 'Video',
                    ])
                    ->default('text')
                    ->required()
                    ->live(), // Tambahkan ini

                Forms\Components\RichEditor::make('content')
                    ->columnSpanFull()
                    ->default('') // Tambahkan nilai default kosong
                    ->required()
                    ->visible(fn ($get) => $get('type') === 'text'), // Tampilkan hanya jika tipe adalah text

                Forms\Components\TextInput::make('video_url') // Tambahkan ini
                    ->label('Video URL')
                    ->url()
                    ->placeholder('https://www.youtube.com/watch?v=example atau https://youtu.be/example')
                    ->required(fn ($get) => $get('type') === 'video') // Wajib diisi jika tipe adalah video
                    ->rule('regex:/^(https:\/\/www\.youtube\.com\/watch\?v=|https:\/\/youtu\.be\/)/') // Validasi URL YouTube
                    ->visible(fn ($get) => $get('type') === 'video'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('courseSection.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('courseSection.course.name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type') // Tambahkan ini
                    ->label('Content Type')
                    ->sortable(),

                Tables\Columns\TextColumn::make('video_url') // Tambahkan ini
                    ->label('Video URL')
                    ->url(fn ($record) => $record->video_url ?: '#') // Fallback ke '#' jika kosong
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListSectionContents::route('/'),
            'create' => Pages\CreateSectionContent::route('/create'),
            'edit' => Pages\EditSectionContent::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
