<?php

return [
    'block1' => [
        'title' => 'Block 1',
        'category' => 'common',
        'icon' => 'dashboard',
        'fields' => [
            'field_boolean' => [
                'label' => 'Boolean',
                'control' => 'toggle',
                'default' => false
            ],
            'field_int' => [
                'label' => 'Field Int',
                'control' => 'number',
                'default' => '24'
            ],
            'selector' => [
                'label' => 'Selector',
                'control' => 'select',
                'options' => [
                    '1' => '1',
                    '2' => 'two'
                ]
            ],
            'field_text' => [
                'label' => 'Text',
                'control' => 'text'
            ]
    ],
    'block2' => [
        'title' => 'Block 2',
        'category' => 'common',
        'icon' => 'search',
    ]
];
