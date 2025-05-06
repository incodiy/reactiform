<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class ButtonComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        // Set default type
        if(!isset($config['type'])) {
            $config['type'] = 'button';
        }
        
        $this->config = $config;
    }

    public function render()
    {
        return view('reactiform::components.button', ['config' => $this->config]);
    }
}