# Advanced Components

## Rich Text Editor
### Basic Usage
```php
Form::richtext('content', [
    'toolbar' => ['bold', 'italic', 'link'],
    'upload_handler' => route('editor.upload'),
    'max_length' => 5000
]);
```

**Configuration Options:**
```php
'richtext' => [
    'toolbar' => [
        ['header', 'bold', 'italic'],
        ['link', 'image', 'video'],
        ['code-block']
    ],
    'upload_handler' => '/api/upload', // Required for image upload
    'max_length' => 10000
]
```

## Combobox
### Async Search
```php
Form::combobox('tags', [], [
    'async_source' => route('tags.search'),
    'tags' => true,
    'creatable' => true
]);
```

**Validation Rules:**
```php
'tags' => 'required|array|max:5'
```

## Multi-File Upload
```php
Form::multifile('attachments', [
    'max_files' => 3,
    'accept' => 'image/*, .pdf',
    'preview' => false
]);
```

**Error Handling:**
```php
if($errors->has('attachments.*')) {
    foreach($errors->get('attachments.*') as $error) {
        // Handle per-file errors
    }
}
```