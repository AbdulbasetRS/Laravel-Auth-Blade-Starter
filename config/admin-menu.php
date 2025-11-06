<?php

return [
    [
        'order' => 1,
        'title' => 'Home',
        'icon' => 'fa fa-home',
        'route' => 'admin.dashboard',
        // 'permission' => 'view_dashboard',
    ],
    [
        'order' => 2,
        'title' => 'Management Users',
        'icon' => 'fa-solid fa-users',
        // 'permission' => 'management_users',
        'children' => [
            [
                'order' => 1,
                'title' => 'Users',
                'icon' => 'fa-solid fa-users',
                'route' => 'admin.users.index',
                // 'permission' => 'view_users',
            ],
            [
                'order' => 2,
                'title' => 'Create User',
                'icon' => 'fa-solid fa-user-plus',
                'route' => 'admin.users.create',
                // 'permission' => 'create_user',
            ],
        ],
    ],
    [
        'order' => 3,
        'title' => 'Settings',
        'icon' => 'fa-solid fa-gear',
        'route' => 'admin.settings.index',
    ],
];
