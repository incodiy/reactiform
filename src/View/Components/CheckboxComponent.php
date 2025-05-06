<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class CheckboxComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        // Format options
        $this->config['options'] = array_map(function ($option) {
            return is_array($option) ? $option : [
                'value' => $option,
                'label' => Str::title(str_replace(['_', '-'], ' ', $option))
            ];
        }, $config['options']);
        
        $this->config = $config;
    }

    public function render()
    {
        return view('reactiform::components.checkbox', ['config' => $this->config]);
    }
}