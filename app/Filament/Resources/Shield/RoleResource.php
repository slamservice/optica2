<?php

namespace App\Filament\Resources\Shield;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\Filament\Resources\Shield\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('filament-shield::filament-shield.field.name'))
                                    ->required()
                                    ->maxLength(255)
                                    ->afterStateUpdated(fn (Closure $set, $state): string => $set('name', Str::lower($state))),
                                Forms\Components\TextInput::make('guard_name')
                                    ->label(__('filament-shield::filament-shield.field.guard_name'))
                                    ->default(config('filament.auth.guard'))
                                    ->nullable()
                                    ->maxLength(255)
                                    ->afterStateUpdated(fn (Closure $set, $state): string => $set('guard_name', Str::lower($state))),
                                Forms\Components\Toggle::make('select_all')
                                    ->onIcon('heroicon-s-shield-check')
                                    ->offIcon('heroicon-s-shield-exclamation')
                                    ->label(__('filament-shield::filament-shield.field.select_all.name'))
                                    ->helperText(__('filament-shield::filament-shield.field.select_all.message'))
                                    ->reactive()
                                    ->afterStateUpdated(function (Closure $set, $state) {
                                        static::refreshEntitiesStatesViaSelectAll($set, $state);
                                    })
                                    ->dehydrated(fn ($state): bool => $state)
                            ])
                            ->columns([
                                'sm' => 2,
                                'lg' => 3
                            ]),
                    ]),
                Forms\Components\Section::make(__('filament-shield::filament-shield.section'))
                    ->schema([
                        Forms\Components\Tabs::make('Permissions')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.resources'))
                                    ->visible(fn (): bool => (bool) config('filament-shield.tabs.resources'))
                                    ->reactive()
                                    ->schema([
                                        Forms\Components\Grid::make([
                                            'sm' => 2,
                                            'lg' => 3,
                                        ])
                                            ->schema(static::getResourceEntitiesSchema())
                                            ->columns([
                                                'sm' => 2,
                                                'lg' => 3
                                            ])
                                    ]),
                                Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.pages'))
                                    ->visible(fn (): bool => (bool) config('filament-shield.tabs.pages'))
                                    ->reactive()
                                    ->schema([
                                        Forms\Components\Grid::make([
                                            'sm' => 3,
                                            'lg' => 4,
                                        ])
                                            ->schema(static::getPageEntityPermissionsSchema())
                                            ->columns([
                                                'sm' => 3,
                                                'lg' => 4
                                            ])
                                    ]),
                                Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.widgets'))
                                    ->visible(fn (): bool => (bool) config('filament-shield.tabs.widgets'))
                                    ->reactive()
                                    ->schema([
                                        Forms\Components\Grid::make([
                                            'sm' => 3,
                                            'lg' => 4,
                                        ])
                                            ->schema(static::getWidgetEntityPermissionSchema())
                                            ->columns([
                                                'sm' => 3,
                                                'lg' => 4
                                            ])
                                    ]),

                                Forms\Components\Tabs\Tab::make(__('filament-shield::filament-shield.custom'))
                                    ->visible(fn (): bool => (bool) config('filament-shield.tabs.custom_permissions'))
                                    ->reactive()
                                    ->schema([
                                        Forms\Components\Grid::make([
                                            'sm' => 3,
                                            'lg' => 4,
                                        ])
                                            ->schema(static::getCustomEntitiesPermisssionSchema())
                                            ->columns([
                                                'sm' => 3,
                                                'lg' => 4
                                            ])
                                    ]),
                            ])
                            ->columnSpan('full'),
                    ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('name')
                    ->label(__('filament-shield::filament-shield.column.name'))
                    ->formatStateUsing(fn ($state): string => Str::headline($state))
                    ->colors(['primary'])
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('guard_name')
                    ->label(__('filament-shield::filament-shield.column.guard_name'))
                    ->colors(['danger']),
                Tables\Columns\BadgeColumn::make('permissions_count')
                    ->label(__('filament-shield::filament-shield.column.permissions'))
                    ->counts('permissions')
                    ->colors(['success']),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('filament-shield::filament-shield.column.updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'view' => Pages\ViewRole::route('/{record}'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('filament-shield::filament-shield.resource.label.role');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-shield::filament-shield.resource.label.roles');
    }

    protected static function getNavigationGroup(): ?string
    {
        return 'Configurazioni';
    }

    protected static function getNavigationLabel(): string
    {
        return __('filament-shield::filament-shield.nav.role.label');
    }

    protected static function getNavigationIcon(): string
    {
        return __('filament-shield::filament-shield.nav.role.icon');
    }

    /**--------------------------------*
    | Resource Related Logic Start     |
     *----------------------------------*/

    protected static function getResourceEntities(): ?array
    {
        $onlyResources = config('filament-shield.only.resources');
        $resources = config('filament-shield.only.enabled')
            ? $onlyResources
            : Filament::getResources();

        return collect($resources)
            ->filter(function ($resource) use ($onlyResources) {
                if (!empty($onlyResources)) {
                    return true;
                }
                return !in_array(Str::before(Str::afterLast($resource, '\\'), 'Resource'), config('filament-shield.except.resources'));
            })
            ->reduce(function ($roles, $resource) {
                $role = Str::lower(Str::before(Str::afterLast($resource, '\\'), 'Resource'));
                $roles[$role] = $role;
                return $roles;
            }, []);
    }

    public static function getResourceEntitiesSchema()
    {
        return collect(static::getResourceEntities())->reduce(function ($entities, $entity) {
            $entities[] = Forms\Components\Card::make()
                ->schema([
                    Forms\Components\Toggle::make($entity)
                        ->onIcon('heroicon-s-lock-open')
                        ->offIcon('heroicon-s-lock-closed')
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($entity) {

                            collect(config('filament-shield.resource_permission_prefixes'))->each(function ($permission) use ($set, $entity, $state) {
                                $set($permission . '_' . $entity, $state);
                            });

                            if (!$state) {
                                $set('select_all', false);
                            }

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->dehydrated(false),
                    Forms\Components\Fieldset::make('Permissions')
                        ->extraAttributes(['class' => 'text-primary-600', 'style' => 'border-color:var(--primary)'])
                        ->columns([
                            'default' => 2,
                            'xl' => 2
                        ])
                        ->schema(static::getResourceEntityPermissionsSchema($entity))
                ])
                ->columns(2)
                ->columnSpan(1);
            return $entities;
        }, []);
    }

    public static function getResourceEntityPermissionsSchema($entity)
    {
        return collect(config('filament-shield.resource_permission_prefixes'))->reduce(function ($permissions, $permission) use ($entity) {
            $permissions[] = Forms\Components\Checkbox::make($permission . '_' . $entity)
                ->label(Str::headline($permission))
                ->extraAttributes(['class' => 'text-primary-600'])
                ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($entity, $permission) {
                    if (is_null($record)) return;

                    $set($permission . '_' . $entity, $record->checkPermissionTo($permission . '_' . $entity));

                    static::refreshResourceEntityStateAfterHydrated($record, $set, $entity);

                    static::refreshSelectAllStateViaEntities($set, $get);
                })
                ->reactive()
                ->afterStateUpdated(function (Closure $set, Closure $get, $state) use ($entity) {

                    static::refreshResourceEntityStateAfterUpdate($set, $get, Str::of($entity));

                    if (!$state) {
                        $set($entity, false);
                        $set('select_all', false);
                    }

                    static::refreshSelectAllStateViaEntities($set, $get);
                })
                ->dehydrated(fn ($state): bool => $state);
            return $permissions;
        }, []);
    }

    protected static function refreshSelectAllStateViaEntities(Closure $set, Closure $get): void
    {
        $entitiesStates = collect(static::getResourceEntities())
            ->merge(static::getPageEntities())
            ->merge(static::getWidgetEntities())
            ->merge(static::getCustomEntities())
            ->map(function ($entity) use ($get) {
                return (bool) $get($entity);
            });

        if ($entitiesStates->containsStrict(false) === false) {
            $set('select_all', true);
        }

        if ($entitiesStates->containsStrict(false) === true) {
            $set('select_all', false);
        }
    }

    protected static function refreshEntitiesStatesViaSelectAll(Closure $set, $state): void
    {
        collect(static::getResourceEntities())->each(function ($entity) use ($set, $state) {
            $set($entity, $state);
            collect(config('filament-shield.resource_permission_prefixes'))->each(function ($permission) use ($entity, $set, $state) {
                $set($permission . '_' . $entity, $state);
            });
        });

        collect(static::getPageEntities())->each(function ($page) use ($set, $state) {
            $set($page, $state);
        });

        collect(static::getWidgetEntities())->each(function ($widget) use ($set, $state) {
            $set($widget, $state);
        });

        static::getCustomEntities()->each(function ($custom) use ($set, $state) {
            $set($custom, $state);
        });
    }

    protected static function refreshResourceEntityStateAfterUpdate(Closure $set, Closure $get, string $entity): void
    {
        $permissionStates = collect(config('filament-shield.resource_permission_prefixes'))
            ->map(function ($permission) use ($get, $entity) {
                return (bool) $get($permission . '_' . $entity);
            });

        if ($permissionStates->containsStrict(false) === false) {
            $set($entity, true);
        }

        if ($permissionStates->containsStrict(false) === true) {
            $set($entity, false);
        }
    }

    protected static function refreshResourceEntityStateAfterHydrated(Model $record, Closure $set, string $entity): void
    {
        $entities = $record->permissions->pluck('name')
            ->reduce(function ($roles, $role) {
                $roles[$role] = Str::afterLast($role, '_');
                return $roles;
            }, collect())
            ->values()
            ->groupBy(function ($item) {
                return $item;
            })->map->count()
            ->reduce(function ($counts, $role, $key) {
                if ($role === count(config('filament-shield.resource_permission_prefixes'))) {
                    $counts[$key] = true;
                } else {
                    $counts[$key] = false;
                }
                return $counts;
            }, []);

        // set entity's state if one are all permissions are true
        if (in_array($entity, array_keys($entities)) && $entities[$entity]) {
            $set($entity, true);
        } else {
            $set($entity, false);
            $set('select_all', false);
        }
    }
    /**--------------------------------*
    | Resource Related Logic End       |
     *----------------------------------*/

    /**--------------------------------*
    | Page Related Logic Start       |
     *----------------------------------*/
    protected static function getPageEntities(): ?array
    {
        $onlyPages = config('filament-shield.only.pages');
        $pages = config('filament-shield.only.enabled')
            ? $onlyPages
            : Filament::getPages();

        return collect($pages)
            ->filter(function ($page) use ($onlyPages) {
                if (!empty($onlyPages)) {
                    return true;
                }
                return !in_array(Str::afterLast($page, '\\'), config('filament-shield.except.pages'));
            })
            ->reduce(function ($transformedPages, $page) {
                $name = Str::of($page)->after('Pages\\')->snake()->prepend('view_');
                $transformedPages["{$name}"] = "{$name}";
                return $transformedPages;
            }, []);
    }

    protected static function getPageEntityPermissionsSchema(): ?array
    {
        return collect(static::getPageEntities())->reduce(function ($pages, $page) {
            $pages[] = Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Checkbox::make($page)
                        ->label(Str::of($page)->after('view_')->headline())
                        // ->onIcon('heroicon-s-lock-open')
                        // ->offIcon('heroicon-s-lock-closed')
                        ->inline()
                        ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($page) {
                            if (is_null($record)) return;

                            $set($page, $record->checkPermissionTo($page));

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {

                            if (!$state) {
                                $set('select_all', false);
                            }

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->dehydrated(fn ($state): bool => $state)
                ])
                ->columns(1)
                ->columnSpan(1);
            return $pages;
        }, []);
    }
    /**--------------------------------*
    | Page Related Logic End          |
     *----------------------------------*/


    /**--------------------------------*
    | Widget Related Logic Start       |
     *----------------------------------*/
    protected static function getWidgetEntities(): ?array
    {
        $onlyWidgets = config('filament-shield.only.widgets');
        $widgets = config('filament-shield.only.enabled')
            ? $onlyWidgets
            : Filament::getWidgets();

        return collect($widgets)
            ->filter(function ($widget) use ($onlyWidgets) {
                if (!empty($onlyWidgets)) {
                    return true;
                }
                return !in_array(Str::afterLast($widget, '\\'), config('filament-shield.except.widgets'));
            })
            ->reduce(function ($widgets, $widget) {
                $name = Str::of($widget)->after('Widgets\\')->snake()->prepend('view_');
                $widgets["{$name}"] = "{$name}";
                return $widgets;
            }, []);
    }

    protected static function getWidgetEntityPermissionSchema(): ?array
    {
        return collect(static::getWidgetEntities())->reduce(function ($widgets, $widget) {
            $widgets[] = Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Checkbox::make($widget)
                        ->label(Str::of($widget)->after('view_')->headline())
                        // ->helperText(fn($state): string => (bool) $state ? '<span class="font-medium text-success-600">Enabled</span>' : '<span class="font-medium text-danger-600">Disabled</span>')
                        // ->onIcon('heroicon-s-lock-open')
                        // ->offIcon('heroicon-s-lock-closed')
                        ->inline()
                        ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($widget) {
                            if (is_null($record)) return;

                            $set($widget, $record->checkPermissionTo($widget));

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {

                            if (!$state) {
                                $set('select_all', false);
                            }

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->dehydrated(fn ($state): bool => $state)
                ])
                ->columns(1)
                ->columnSpan(1);
            return $widgets;
        }, []);
    }
    /**--------------------------------*
    | Widget Related Logic End          |
     *----------------------------------*/

    protected static function getCustomEntities()
    {
        $resourcePermissions = collect();
        collect(static::getResourceEntities())->each(function ($entity) use ($resourcePermissions) {
            collect(config('filament-shield.resource_permission_prefixes'))->map(function ($permission) use ($resourcePermissions, $entity) {
                $resourcePermissions->push((string) Str::of($permission . '_' . $entity));
            });
        });

        $entitiesPermissions = $resourcePermissions
            ->merge(static::getPageEntities())
            ->merge(static::getWidgetEntities())
            ->values();

        return Permission::whereNotIn('name', $entitiesPermissions)->pluck('name');
    }

    protected static function getCustomEntitiesPermisssionSchema(): ?array
    {
        return collect(static::getCustomEntities())->reduce(function ($customEntities, $customPermission) {
            $customEntities[] = Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\Checkbox::make($customPermission)
                        ->label(Str::of($customPermission)->after('view_')->headline())
                        // ->helperText(fn($state): string => (bool) $state ? '<span class="font-medium text-success-600">Enabled</span>' : '<span class="font-medium text-danger-600">Disabled</span>')
                        // ->onIcon('heroicon-s-lock-open')
                        // ->offIcon('heroicon-s-lock-closed')
                        ->inline()
                        ->afterStateHydrated(function (Closure $set, Closure $get, $record) use ($customPermission) {
                            if (is_null($record)) return;

                            $set($customPermission, $record->checkPermissionTo($customPermission));

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {

                            if (!$state) {
                                $set('select_all', false);
                            }

                            static::refreshSelectAllStateViaEntities($set, $get);
                        })
                        ->dehydrated(fn ($state): bool => $state)
                ])
                ->columns(1)
                ->columnSpan(1);
            return $customEntities;
        }, []);
    }
}
