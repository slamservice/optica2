<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Configurazioni';

    protected static ?int $navigationSort = 1;

    protected static ?string $label = 'Utente';

    protected static ?string $pluralLabel = 'Utenti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Informações pessoais')
                    ->columns([
                        'sm' => 1,
                    ])
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required(),
                                Forms\Components\TextInput::make('email')
                                    ->label('E-mail')
                                    ->email()
                                    ->unique(ignorable: fn (?Model $record): ?Model => $record)
                                    ->required(),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\FileUpload::make('avatar')
                                    ->label('Avatar')
                                    ->directory('users')
                                    ->image(),
                            ]),
                    ]),

                Forms\Components\Fieldset::make('Senhas e configuração de acesso')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->rules(['confirmed'])
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => !is_null($state))
                            ->required(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser),
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirme a senha')
                            ->password()
                            ->required()
                            ->dehydrated(false)
                            ->required(fn (Component $livewire): bool => $livewire instanceof Pages\CreateUser),
                        Forms\Components\Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Forms\Components\Toggle::make('is_super_admin')
                                    ->label('Usuário é Super Administrador')
                                    ->hidden(!User::IsSuperAdmin())
                                    ->inline(),
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Usuário está ativo')
                                    ->inline(),
                            ]),
                        Forms\Components\BelongsToManyMultiSelect::make('Funções')
                            ->label('Funções')
                            ->relationship('roles', 'name')
                            ->columns(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('new_avatar')
                    ->label('')
                    ->size(50)
                    ->rounded(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('roles')
                    ->formatStateUsing(fn ($state): string => $state->implode('name', ', '))
                    ->colors(['danger']),
                Tables\Columns\BooleanColumn::make('is_super_admin')
                    ->label('Super Admin'),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Ativo'),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Usuários ativos')
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
