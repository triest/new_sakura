<?php


return [
    [
        'title' => 'Рабочий стол',
        'mdi_icon' => 'mdi-shield-check',
        'roles' => '1,2',
        'route' => 'admin.home',
    ],

    [
        'title' => 'Спавочники',
        'mdi_icon' => 'mdi-view-list',
        'roles' => '1',
        'items' => [

        ],
    ],
    [
        'title' => 'Настройки',
        'mdi_icon' => 'mdi-settings',
        'roles' => '1',
        'items' => [
            [
                'title' => 'Пользователи',
                'roles' => '1',
                'route' => 'admin.settings.admin_users.index',
            ]
        ],
    ]
];
