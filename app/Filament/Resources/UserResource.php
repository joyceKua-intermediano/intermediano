<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function getNavigationLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        // get users permissions from roles
        // $form->getRecord()->getPermissionsViaRoles()->pluck("name")->toArray()
        
        return $form
            ->schema([
                Section::make()->schema([
                    Forms\Components\TextInput::make('name')->label(__("Name"))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->unique(ignoreRecord: true)
                        ->label(__("Email"))
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DateTimePicker::make('email_verified_at')->label(__("Email verified at")),
            
                    Forms\Components\FileUpload::make('avatar_url')->image()->imageEditor()->label(__("Avatar")),
                    Select::make("roles")->relationship("roles", "name")->label(__("Role"))
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')->label(__("Avatar"))->circular(),
                Tables\Columns\TextColumn::make('name')->label(__("Name"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__("Email"))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')->label(__("Email verified at"))
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label(__("Created at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label(__("Updated at"))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),                
            ])
            ->filters([
                SelectFilter::make("roles")->options(Role::pluck("name", "id"))
                ->modifyQueryUsing(function (Builder $query, $state) {
                    if (! $state['value']) {
                        return $query;
                    }
                    return $query->whereHas('roles', fn($query) => $query->where('id', $state['value']));
                })
            ])
            ->actions([
                ViewAction::make(),
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
