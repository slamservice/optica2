<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

//    protected function getEditForm(): array
//    {
//        return [
//            Forms\Components\Grid::make()
//                ->columns(1)
//                ->schema([
//                    Forms\Components\TextInput::make('name')
//                        ->label('Nome')
//                        ->maxLength(255)
//                        ->required(),
//                    Forms\Components\FileUpload::make('avatar')
//                        ->label('Avatar')
//                        ->directory('users')
//                        ->image()
//                        ->imagePreviewHeight('180'),
//                    Forms\Components\BelongsToManyMultiSelect::make('roles')
//                        ->label('Função de usuário')
//                        ->exists( Role::class)
//                        ->relationship('roles', 'name')
//                        ->required(),
//                ]),
//            Forms\Components\Fieldset::make('Senhas de acesso')
//                ->schema([
//                    Forms\Components\TextInput::make('password')
//                        ->label('Senha')
//                        ->password()
//                        ->minLength(8)
//                        ->same('password_confirmation')
//                        ->dehydrateStateUsing(fn($state) => Hash::make($state)),
//                    Forms\Components\TextInput::make('password_confirmation')
//                        ->label('Confirme a senha')
//                        ->password()
//                        ->dehydrated(false),
//                    Forms\Components\Toggle::make('is_super_admin')
//                        ->label('Permissão especial Super Admin')
//                        ->hidden(!User::IsSuperAdmin())
//                        ->inline(),
//                    Forms\Components\Toggle::make('is_active')
//                        ->label('Usuário está ativo')
//                        ->inline(),
//                ])
//        ];
//    }

//    public function getForms(): array
//    {
//        return [
//            'form' => $this->makeForm()
//                ->model($this->record)
//                ->schema($this->getEditForm())
//                ->statePath('data'),
//        ];
//    }

//    protected function mutateFormDataBeforeSave(array $data): array
//    {
//        if ($data['password'] !== null) {
//            return $data;
//        }
//
//        return Arr::except($data, ['password']);;
//
//    }
//
//    protected function getRedirectUrl(): ?string
//    {
//        return static::getResource()::getUrl();
//    }

}
