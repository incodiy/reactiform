<?php
namespace Incodiy\Reactiform;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Incodiy\Reactiform\Contracts\FormInterface;
use Incodiy\Reactiform\Helpers\FormHelper;

/**
 * 
 *  Pada Controller
    return Form::open([
        'action' => route('form.submit'),
        'method' => 'PUT',
        'class' => 'ajax-form'
    ])
    ->text('Username')
    ->select('Country', $countries)
    ->submit('Save Changes', ['class' => 'btn-lg'])
    ->button('Cancel', 'button', [
        'onClick' => 'window.history.back()'
    ])
    ->close()
    ->render();
 */
class FormGenerator
{
    use FormHelper;
    
    protected static $idCounter = 0;
    protected $elements = [];
    protected $formConfig = [];
    protected $buttons = [];
    
    public function __construct()
    {
        $this->validationErrors = session()->get('errors')?->getMessages() ?? [];
    }

    private function applyValidation($name, &$attributes)
    {
        if($errors = Arr::get($this->validationErrors, $name)) {
            $attributes['class'] .= ' has-error';
            $attributes['data-errors'] = json_encode($errors);
        }
        
        if(Arr::get($attributes, 'required')) {
            $attributes['data-rules'] = 'required';
        }
    }

    public function open(array $attributes = [])
    {
        $this->formConfig = array_merge([
            'method' => 'POST',
            'action' => url()->current(),
            'enctype' => 'application/x-www-form-urlencoded',
            'attributes' => []
        ], $attributes);

        // Auto-add CSRF and method spoofing
        if ($this->formConfig['method'] !== 'GET') {
            $this->hidden('_token', ['value' => csrf_token()]);
            
            if (!in_array($this->formConfig['method'], ['GET', 'POST'])) {
                $this->hidden('_method', ['value' => $this->formConfig['method']]);
                $this->formConfig['method'] = 'POST';
            }
        }

        return $this;
    }

    public function close(array $buttons = [])
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function submit($label = 'Submit', $attributes = [])
    {
        $this->buttons[] = array_merge([
            'type' => 'submit',
            'label' => $label,
            'class' => 'btn-primary'
        ], $attributes);

        return $this;
    }

    public function button($label, $type = 'button', $attributes = [])
    {
        $this->buttons[] = array_merge([
            'type' => $type,
            'label' => $label,
            'class' => 'btn-secondary'
        ], $attributes);

        return $this;
    }

    protected function commonSetup($name, $attributes, $label = true)
    {
        // Generate ID if not provided
        if (!isset($attributes['id'])) {
            $attributes['id'] = Str::slug($name) . '-' . self::$idCounter++;
        }
        
        $this->applyValidation($name, $attributes);

        return [
            'name' => Str::slug($name, '-'),
            'label' => $label ? Str::title(str_replace(['-', '_'], ' ', $name)) : '',
            'showLabel' => $label,
            'attributes' => $this->processAttributes($attributes)
        ];
    }
    
    /**
     * 
        $form->select('Project Tags', ['php', 'js', 'python', 'java'], [
            'multiple' => true,
            'class' => 'form-multiselect',
            'size' => 4,
            'required' => true
        ]);

        $form->select(
            'User Roles', 
            ['admin', 'editor', 'viewer'],
            ['multiple' => true, 'class' => 'form-roles'],
            ['admin', 'editor'] // Nilai terpilih
        );

        Form::select(
            'User Roles',
            ['admin' => 'Administrator', 'user' => 'Regular User'],
            [
                'multiple' => true,
                'required' => true,
                'class' => 'form-multiselect',
                'data-help' => 'Max 3 pilihan',
                'empty_option' => 'Pilih peran'
            ],
            ['admin']
        );
    */
    public function select($select_name, $select_values, $select_attributes = [], $selected = [])
    {
        // Extract label visibility
        $showLabel = Arr::pull($select_attributes, 'label', true);

        // Process name and label
        $name = Str::slug($select_name, '-');
        $label = $showLabel ? Str::title(str_replace(['-', '_'], ' ', $select_name)) : '';
        
        // Handle multiple selection
        $isMultiple = Arr::pull($select_attributes, 'multiple', false);
        if($isMultiple) {
            $name .= '[]'; // Tambahkan [] untuk multiple selection
        }

        // Process name and label
        $name = Str::slug($select_name, '-');
        $label = Str::title(str_replace(['-', '_'], ' ', $select_name));
        
        // Generate ID if not provided
        if (!isset($select_attributes['id'])) {
            $select_attributes['id'] = $name . '-' . self::$idCounter++;
        }

        // Process options
        // $options = array_map(function ($value) {
        //     return [
        //         'value' => $value,
        //         'label' => Str::title(str_replace(['_', '-'], ' ', $value))
        //     ];
        // }, $select_values);
        
        // Proses selected values
        $options = array_map(function ($value) use ($selected) {
            return [
                'value' => $value,
                'label' => Str::title(str_replace(['_', '-'], ' ', $value)),
                'selected' => in_array($value, (array)$selected)
            ];
        }, $select_values);

        // Add empty option
        array_unshift($options, ['value' => '', 'label' => '']);

        // Add empty option with configurable label
        $emptyOptionLabel = Arr::pull($select_attributes, 'empty_option', '');
        array_unshift($options, [
            'value' => '',
            'label' => $emptyOptionLabel,
            'selected' => false
        ]);

        // Store element configuration
        // $this->elements[] = [
        //     'type' => 'select',
        //     'name' => $name,
        //     'label' => $label,
        //     'options' => $options,
        //     'attributes' => $this->processAttributes($select_attributes),
        // ];

        // Store element configuration
        $this->elements[] = [
            'type' => 'select',
            'name' => $name,
            'label' => $label,
            'showLabel' => $showLabel, // Tambah properti ini
            'options' => $options,
            'attributes' => $this->processAttributes($select_attributes),
        ];

        return $this;
    }

    // Text Input
    public function text($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'text',
            'inputType' => 'text'
        ]);
        
        return $this;
    }

    // Email Input
    public function email($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'email',
            'inputType' => 'email'
        ]);
        
        return $this;
    }

    // Textarea
    public function textarea($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'textarea',
            'rows' => Arr::pull($attributes, 'rows', 3)
        ]);
        
        return $this;
    }

    // Checkbox
    public function checkbox($name, $options, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'checkbox',
            'options' => $this->processOptions($options),
            'stacked' => Arr::pull($attributes, 'stacked', false)
        ]);
        
        return $this;
    }

    // Radio
    public function radio($name, $options, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'radio',
            'options' => $this->processOptions($options),
            'stacked' => Arr::pull($attributes, 'stacked', false)
        ]);
        
        return $this;
    }

    // File Upload
    public function file($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes, Arr::pull($attributes, 'label', true));
        
        $this->elements[] = array_merge($config, [
            'type' => 'file',
            'multiple' => Arr::pull($attributes, 'multiple', false),
            'accept' => Arr::pull($attributes, 'accept', '*/*')
        ]);
        
        return $this;
    }

    // Helper Methods
    protected function processOptions($options)
    {
        return array_map(function ($value) {
            return [
                'value' => $value,
                'label' => Str::title(str_replace(['_', '-'], ' ', $value))
            ];
        }, $options);
    }

    /**
        Form::date('birth_date', [
            'min' => '1900-01-01',
            'max' => now()->format('Y-m-d'),
            'format' => 'dd/mm/yyyy',
            'class' => 'custom-datepicker'
        ], '1990-01-01');
     */
    public function date($name, $attributes = [], $selected = null)
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'date',
            'picker_type' => 'date',
            'selected' => $selected,
            'min_date' => Arr::get($attributes, 'min'),
            'max_date' => Arr::get($attributes, 'max'),
            'date_format' => Arr::get($attributes, 'format', 'Y-m-d'),
            'show_time' => false
        ]);
        
        return $this;
    }

    public function datetime($name, $attributes = [], $selected = null)
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'date',
            'picker_type' => 'datetime',
            'selected' => $selected,
            'min_date' => Arr::get($attributes, 'min'),
            'max_date' => Arr::get($attributes, 'max'),
            'date_format' => Arr::get($attributes, 'format', 'Y-m-d H:i'),
            'time_format' => Arr::get($attributes, 'time_format', 'HH:mm'),
            'show_time' => true,
            'time_intervals' => Arr::get($attributes, 'intervals', 30)
        ]);
        
        return $this;
    }

    /**
        Form::range('price_range', [
            'min' => 0,
            'max' => 1000,
            'step' => 50,
            'ticks' => [0, 500, 1000],
            'data-unit' => 'USD'
        ]);
     */
    public function range($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'range',
            'min' => Arr::get($attributes, 'min', 0),
            'max' => Arr::get($attributes, 'max', 100),
            'step' => Arr::get($attributes, 'step', 1),
            'default_value' => Arr::get($attributes, 'value', 0),
            'ticks' => Arr::get($attributes, 'ticks', []),
            'show_ticks' => Arr::get($attributes, 'show_ticks', false)
        ]);
        
        return $this;
    }

    /**
        Form::mask('phone_number', [
            'mask' => '+62 (999) 9999-9999',
            'regex' => '^\+62 \(\d{3}\) \d{4}-\d{4}$',
            'placeholder' => '_'
        ]);
     */
    public function mask($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'mask',
            'mask_pattern' => Arr::get($attributes, 'mask', '***-***'),
            'placeholder_char' => Arr::get($attributes, 'placeholder', '_'),
            'regex_validation' => Arr::get($attributes, 'regex'),
            'show_mask_format' => Arr::get($attributes, 'show_format', true)
        ]);
        
        return $this;
    }
    
    /**
        Form::open(['enctype' => 'multipart/form-data'])
        ->richtext('content', [
            'toolbar' => ['bold', 'italic', 'link', 'image'],
            'max_length' => 10000
        ])
        ->submit('Publish')
        ->close()
        ->render();
     */
    public function richtext($name, $attributes = [], $content = '')
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'richtext',
            'content' => $content,
            'toolbar' => Arr::get($attributes, 'toolbar', [
                'bold', 'italic', 'underline', 'strike',
                'link', 'image', 'code-block', 'blockquote'
            ]),
            'upload_handler' => Arr::get($attributes, 'upload_handler'),
            'max_length' => Arr::get($attributes, 'max_length', 5000)
        ]);
        
        return $this;
    }
    
    /**
        Form::open(['enctype' => 'multipart/form-data'])
        ->combobox('tags', $tags, [
            'tags' => true,
            'creatable' => true,
            'async_source' => route('tags.search')
        ])
        ->submit('Publish')
        ->close()
        ->render();
     */
    public function combobox($name, $options, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'combobox',
            'options' => $options,
            'async_source' => Arr::get($attributes, 'async_source'),
            'tags' => Arr::get($attributes, 'tags', false),
            'creatable' => Arr::get($attributes, 'creatable', false),
            'min_chars' => Arr::get($attributes, 'min_chars', 2)
        ]);
        
        return $this;
    }

    protected function processMultiFileAttributes($name, &$attributes)
    {
        $this->applyValidation($name, $attributes);
        
        if(isset($attributes['rules'])) {
            $attributes['data-rules'] = $attributes['rules'];
            unset($attributes['rules']);
        }
    }

    public function multifile($name, $attributes = [])
    {
        $this->processMultiFileAttributes($name, $attributes);
        
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'multifile',
            'max_files' => Arr::get($attributes, 'max_files', 5),
            'max_size' => Arr::get($attributes, 'max_size', '10MB'),
            'preview' => Arr::get($attributes, 'preview', true),
            'accept' => Arr::get($attributes, 'accept', '*/*')
        ]);
        
        return $this;
    }
    
    /**
        Backend Handler:
        // Route untuk file upload RTE
        Route::post('/reactiform/upload', function (Request $request) {
            $path = $request->file('file')->store('public/richtext');
            return response()->json([
                'url' => Storage::url($path)
            ]);
        })->name('reactiform.upload');

        Penggunaan:
        Form::open(['enctype' => 'multipart/form-data'])
        ->multifile('attachments', [
            'accept' => 'image/*, .pdf',
            'max_files' => 3
        ])
        ->submit('Publish')
        ->close()
        ->render();
     */
    // public function multifile($name, $attributes = [])
    // {
    //     $config = $this->commonSetup($name, $attributes);
        
    //     $this->elements[] = array_merge($config, [
    //         'type' => 'multifile',
    //         'max_files' => Arr::get($attributes, 'max_files', 5),
    //         'max_size' => Arr::get($attributes, 'max_size', '10MB'),
    //         'preview' => Arr::get($attributes, 'preview', true),
    //         'accept' => Arr::get($attributes, 'accept', '*/*')
    //     ]);
        
    //     return $this;
    // }

    public function signature($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'signature',
            'pen_color' => Arr::get($attributes, 'pen_color', '#000000'),
            'background' => Arr::get($attributes, 'background', '#FFFFFF'),
            'clear_button' => Arr::get($attributes, 'clear_button', true),
            'max_width' => Arr::get($attributes, 'max_width', 400)
        ]);
        
        return $this;
    }

    public function geolocation($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'geolocation',
            'map_provider' => Arr::get($attributes, 'map_provider', 'openstreetmap'),
            'default_coords' => Arr::get($attributes, 'default_coords', [0, 0]),
            'search_radius' => Arr::get($attributes, 'search_radius', 1000), // meter
            'map_height' => Arr::get($attributes, 'map_height', '400px')
        ]);
        
        return $this;
    }

    public function rating($name, $attributes = [])
    {
        $config = $this->commonSetup($name, $attributes);
        
        $this->elements[] = array_merge($config, [
            'type' => 'rating',
            'max' => Arr::get($attributes, 'max', 5),
            'icons' => Arr::get($attributes, 'icons', ['star']),
            'half' => Arr::get($attributes, 'half', false),
            'color' => Arr::get($attributes, 'color', '#ffd700')
        ]);
        
        return $this;
    }

    // protected function processAttributes($attributes)
    // {
    //     // Convert to React-compatible attributes
    //     $processed = [];
    //     foreach ($attributes as $key => $value) {
    //         if ($key === 'class') {
    //             $processed['className'] = $value;
    //         } else {
    //             $processed[$key] = $value;
    //         }
    //     }
    //     return $processed;
    // }

    // public function render()
    // {
    //     return view('form-components', [
    //         'elements' => $this->elements
    //     ]);
    // }

    protected function processAttributes($attributes)
    {
        $processed = [];
        foreach ($attributes as $key => $value) {
            $processed[($key === 'class') ? 'className' : $key] = $value;
        }
        return $processed;
    }

    public function render()
    {
        return view('form-components::form-container', [
            'elements' => $this->elements,
            'formConfig' => $this->formConfig,
            'buttons' => $this->buttons,
            'validationErrors' => $this->validationErrors // Tambahkan ini
        ]);
    }
}