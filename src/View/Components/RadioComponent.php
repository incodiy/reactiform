<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class RadioComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        $this->config = $config;
        
        // Generate unique name for radio group
        $this->config['group_name'] = Str::slug($config['name']) . '-radio-group';
    }

    public function render()
    {
        return view('reactiform::components.radio', ['config' => $this->config]);
    }
}