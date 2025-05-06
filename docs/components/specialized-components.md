## Signature Pad
```php
Form::signature('contract_signature', [
    'pen_color' => '#ff0000',
    'background' => '#f0f0f0',
    'max_width' => 500
]);
```

## Geolocation Picker
```php
Form::geolocation('meeting_location', [
    'default_coords' => [-6.200000, 106.816666], // Jakarta
    'search_radius' => 5000,
    'map_height' => '500px'
]);
```

## Rating System
```php
Form::rating('product_rating', [
    'max' => 10,
    'color' => '#4ade80',
    'half' => true
]);
```