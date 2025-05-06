# Laravel React Form Generator

[![Latest Version](https://img.shields.io/github/v/release/incodiy/reactiform)](https://github.com/incodiy/reactiform)
[![License](https://img.shields.io/github/license/incodiy/reactiform)](LICENSE.md)
[![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)](https://laravel.com)
[![React](https://img.shields.io/badge/React-18+-blue.svg)](https://reactjs.org)

Powerful form generator for Laravel with React frontend components. Create complex forms with minimal code while maintaining full customization capabilities.

## Features

- 🚀 10+ Pre-built Form Components
- ⚡ Automatic ID Generation
- 🎨 Customizable Styling
- 🔧 Extensible Architecture
- ♿ Accessibility Ready
- 📱 Responsive Design
- 🛠️ Laravel Validation Integration

## Prerequisites

- PHP 8.1+
- Laravel 10+
- React 18+
- Node.js 16+
- Composer 2+

## Installation

    composer require incodiy/reactiform


## Publish assets

    php artisan vendor:publish --provider="YourNamespace\Form\Providers\FormServiceProvider" --tag=form-components



## Quick Start

1. Create form in controller:

    use Incodiy\Reactiform\Facades\Form;

    public function show()
    {
        return Form::text('Username', ['placeholder' => 'Enter your username'])
            ->select('Country', ['us', 'id', 'jp'], ['required' => true])
            ->render();
    }

2. Display in Blade:

    <!DOCTYPE html>
    <html>
    <head>
        @viteReactRefresh
        @vite(['resources/js/app.js'])
    </head>
    <body>
        {!! $form !!}
    </body>
    </html>


## Available Components

Text Input

    Form::text('Email Address', [
        'type' => 'email',
        'label' => false,
        'class' => 'custom-input'
    ]);

Select Box

    Form::select('User Role', ['admin', 'user', 'guest'], [
        'multiple' => true,
        'placeholder' => 'Select roles'
    ]);

Checkbox Group

    Form::checkbox('Preferences', ['newsletter', 'notifications'], [
        'stacked' => true,
        'default' => ['newsletter']
    ]);

## Multiple Selection

    Aktifkan mode multiple dengan menambahkan parameter `multiple`:

    Form::select(
        'Project Tags',
        ['php', 'js', 'python'],
        [
            'multiple' => true,
            'class' => 'form-multiselect',
            'size' => 4
        ],
        ['php'] // Nilai terpilih
    );

## Konfigurasi Khusus

    Parameter	Tipe	Default	Deskripsi
    multiple	bool	false	Aktifkan multiple selection
    size	int	4	Jumlah opsi yang tampil
    min_selected	int	1	Minimal pilihan wajib
    max_selected	int	10	Maksimal pilihan yang diperbolehkan

## Validasi

    // Controller
    $rules = [
        'tags' => 'required|array|min:2|max:5'
    ];

    $messages = [
        'tags.max' => 'Maksimal memilih 5 tag'
    ];

## Custom Styling

    /* resources/css/form.css */
    .form-multiselect {
        border: 2px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }

    .form-multiselect:focus {
        border-color: #4299e1;
    }


## Advanced Usage

    Form::open([
        'action' => '/contact',
        'method' => 'POST',
        'enctype' => 'multipart/form-data',
        'data-ajax' => 'true'
    ])
    ->file('attachment')
    ->submit('Upload', ['icon' => 'fa-upload'])
    ->close();

## Button Types

    // Submit button
    ->submit('Save', ['class' => 'btn-save'])

    // Reset button
    ->button('Reset Form', 'reset')

    // Custom action
    ->button('Preview', 'button', [
        'onClick' => 'showPreview()'
    ])

## Form Security

    CSRF token otomatis ditambahkan

    Method spoofing untuk PUT/PATCH/DELETE

    Proteksi XSS otomatis

## Configuration

Create config/form.php:

    return [
        'defaults' => [
            'text' => [
                'class' => 'form-input',
                'wrapper_class' => 'form-group'
            ],
            'select' => [
                'empty_option' => '-- Select --',
                'searchable' => true
            ]
        ],
        'validation' => [
            'auto_apply' => true,
            'error_class' => 'error-field'
        ]
    ];


# Advanced Components

## Rich Text Editor
### Basic Usage

    Form::richtext('content', [
        'toolbar' => ['bold', 'italic', 'link'],
        'upload_handler' => route('editor.upload'),
        'max_length' => 5000
    ]);


**Configuration Options:**

    'richtext' => [
        'toolbar' => [
            ['header', 'bold', 'italic'],
            ['link', 'image', 'video'],
            ['code-block']
        ],
        'upload_handler' => '/api/upload', // Required for image upload
        'max_length' => 10000
    ]


## Combobox
### Async Search

    Form::combobox('tags', [], [
        'async_source' => route('tags.search'),
        'tags' => true,
        'creatable' => true
    ]);


**Validation Rules:**

    'tags' => 'required|array|max:5'


## Multi-File Upload

    Form::multifile('attachments', [
        'max_files' => 3,
        'accept' => 'image/*, .pdf',
        'preview' => false
    ]);

**Error Handling:**

    if($errors->has('attachments.*')) {
        foreach($errors->get('attachments.*') as $error) {
            // Handle per-file errors
        }
    }


# Penggunaan Theme:

## Custom Theme

    Create `custom-theme.css`:

    :root {
        --reactiform-primary: #8b5cf6;
    }

## Publish assets:

    php artisan vendor:publish --tag=reactiform-themes

## Include in blade:

    <link href="{{ asset('vendor/reactiform/themes/custom-theme.css') }}" rel="stylesheet">



## Documentation
Full documentation available at:
https://incodiy.github.io/reactiform
Contributing

    Fork the repository

    Create feature branch

    Submit PR with tests

License

MIT License - See LICENSE file