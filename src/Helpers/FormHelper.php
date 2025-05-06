<?php

namespace Incodiy\Reactiform\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class FormHelper
{
    /**
     * Process HTML attributes for React compatibility
     */
    public static function processAttributes(array $attributes): array
    {
        $processed = [];
        foreach ($attributes as $key => $value) {
            $reactKey = match($key) {
                'class'    => 'className',
                'readonly' => 'readOnly',
                'autofocus' => 'autoFocus',
                'maxlength' => 'maxLength',
                default    => $key
            };
            $processed[$reactKey] = $value;
        }
        return $processed;
    }

    /**
     * Generate unique ID for form elements
     */
    public static function generateId(string $name): string
    {
        static $idCounter = 0;
        return Str::slug($name) . '-' . $idCounter++;
    }

    /**
     * Process options for select/radio/checkbox
     */
    public static function processOptions(array $options, array $selected = []): array
    {
        return array_map(function ($value, $label) use ($selected) {
            if (is_array($label)) {
                return [
                    'value'    => $label['value'],
                    'label'    => $label['label'],
                    'selected' => in_array($label['value'], $selected)
                ];
            }
            
            return [
                'value'    => $value,
                'label'    => is_string($label) ? $label : Str::title(str_replace(['_', '-'], ' ', $value)),
                'selected' => in_array($value, $selected)
            ];
        }, array_keys($options), $options);
    }

    /**
     * Extract label configuration
     */
    public static function extractLabel(array &$attributes): array
    {
        return [
            'show'  => Arr::pull($attributes, 'label', true),
            'text'  => Arr::pull($attributes, 'label_text'),
            'class' => Arr::pull($attributes, 'label_class')
        ];
    }
}