<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Table Columns
    |--------------------------------------------------------------------------
    */

    'column.name' => 'Name',
    'column.guard_name' => 'Guard Name',
    'column.roles' => 'Ruoli',
    'column.permissions' => 'Permessi',
    'column.updated_at' => 'Updated At',

    /*
    |--------------------------------------------------------------------------
    | Form Fields
    |--------------------------------------------------------------------------
    */

    'field.name' => 'Name',
    'field.guard_name' => 'Guard Name',
    'field.permissions' => 'Permessi',
    'field.select_all.name' => 'Seleziona Tutti',
    'field.select_all.message' => 'Abilita tutti i permessi per questo ruolo',

    /*
    |--------------------------------------------------------------------------
    | Navigation & Resource
    |--------------------------------------------------------------------------
    */

    'nav.group' => 'Filament Shield',
    'nav.role.label' => 'Ruoli',
    'nav.role.icon' => 'heroicon-o-shield-check',
    'resource.label.role' => 'Ruolo',
    'resource.label.roles' => 'Ruoli',

    /*
    |--------------------------------------------------------------------------
    | Section & Tabs
    |--------------------------------------------------------------------------
    */
    'section' => 'Entities',
    'resources' => 'Resources',
    'widgets' => 'Widgets',
    'pages' => 'Pages',
    'custom' => 'Custom Permissions',

    /**
     * HasPageShield Trait Forbidden Message
     */
    'forbidden' => 'Non hai i permessi necessari per accedere',
];
