<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class TextareaComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        // Set default rows
        if(!isset($config['attributes']['rows'])) {
            $config['attributes']['rows'] = 3;
        }
        
        $this->config = $config;
    }

    public function render()
    {
        return view('reactiform::components.textarea', ['config' => $this->config]);
    }
}