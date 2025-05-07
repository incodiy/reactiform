<?php

namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class DateComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        $this->config = $config;
        
        // Set default date format
        if(!isset($this->config['date_format'])) {
            $this->config['date_format'] = 'Y-m-d';
        }
    }

    public function render()
    {
        return view('reactiform::components.date', [
            'config' => $this->config
        ]);
    }
}