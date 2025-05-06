<?php

namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

// class SelectComponent extends Component
// {
//     public $config;

//     public function __construct($config)
//     {
//         $this->config = $config;
//     }

//     public function render()
//     {
//         return view('reactiform::components.select', [
//             'config' => $this->config
//         ]);
//     }
// }

class SelectComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        // Handle empty option label
        if(empty($config['options'][0]['label'])) {
            $config['options'][0]['label'] = config('reactiform.defaults.select.empty_option', '-- Select --');
        }
        
        $this->config = $config;
    }

    public function render()
    {
        return view('reactiform::components.select', [
            'config' => $this->config
        ]);
    }
}