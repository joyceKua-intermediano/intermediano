<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('contact_name')->required()->maxLength(255)->label(__("Contact Name")),
                Forms\Components\TextInput::make('surname')->maxLength(255)->label(__("Surname")),
                Forms\Components\TextInput::make('email')->maxLength(255)->label(__("Email")),
                Forms\Components\TextInput::make('linkedin')->maxLength(255)->label(__("Linkedin")),
                Forms\Components\TextInput::make('mobile')->maxLength(255)->label(__("Mobile phone")),
                Forms\Components\TextInput::make('position')->maxLength(255)->label(__("Job Title")),
                Forms\Components\TextInput::make('department')->maxLength(255)->label(__("Department")),
                Forms\Components\Toggle::make('is_main_contact')->required()->label(__("Is Main Contact")),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('contact_name')
            ->columns([
                ToggleColumn::make('is_main_contact')->label(__("Is Main Contact")),
                Tables\Columns\TextColumn::make('contact_name')->label(__("Contact Name")),
                Tables\Columns\TextColumn::make('surname')->label(__("Surname")),
                Tables\Columns\TextColumn::make('email')->label(__("Email")),
                Tables\Columns\TextColumn::make('linkedin')->label(__("Linkedin")),
                Tables\Columns\TextColumn::make('mobile')->label(__("Mobile phone")),
                Tables\Columns\TextColumn::make('position')->label(__("Job Title")),
                Tables\Columns\TextColumn::make('department')->label(__("Department")),
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
