<?php

return [
    'defaults' => [
        'form' => [
            'default_method' => 'POST',
            'auto_csrf' => true,
            'buttons' => [
                'submit_class' => 'btn-primary',
                'reset_class' => 'btn-secondary'
            ]
        ],
        'text' => [
            'class' => 'form-input',
            'wrapper_class' => 'form-group'
        ],
        'select' => [
            'searchable' => false,
            'empty_option' => '-- Please Select --',
            'multiple' => [
                'min_selected' => 1,
                'max_selected' => 3,
                'selection_message' => 'Select between 1-3 options',
                'help_text' => 'Hold Ctrl/Cmd for multiple selection',
            ]
        ],
        'date' => [
            'format' => 'Y-m-d',
            'time_format' => 'H:i'
        ],
        'date' => [
            'format' => 'Y-m-d',
            'time_format' => 'H:i',
            'show_time' => false,
            'intervals' => 30,
            'class' => 'form-datepicker'
        ],
        'range' => [
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'show_ticks' => true,
            'class' => 'form-range-slider'
        ],
        'mask' => [
            'placeholder' => '_',
            'show_format' => true,
            'class' => 'form-masked'
        ],
        'richtext' => [
            'toolbar' => [
                ['bold', 'italic'],
                ['link', 'image'],
                ['clean']
            ],
            'upload_handler' => route('reactiform.upload'),
            'max_length' => 5000
        ],
        'combobox' => [
            'min_chars' => 2,
            'tags' => false,
            'creatable' => false
        ],
        'multifile' => [
            'preview' => true,
            'max_size' => '10MB',
            'max_files' => 5
        ]
    ],
    'validation' => [
        'auto_apply' => true,
        'error_class' => 'has-error'
    ],
    'signature' => [
        'pen_color' => '#000000',
        'background' => '#FFFFFF',
        'max_width' => 400
    ],
    'geolocation' => [
        'map_provider' => 'openstreetmap',
        'map_height' => '400px'
    ],
    'rating' => [
        'max' => 5,
        'color' => '#ffd700'
    ]
];