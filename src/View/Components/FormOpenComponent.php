<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class FormOpenComponent extends Component
{
    public $config;
    
    public function __construct($config = [])
    {
        $defaults = [
            'method' => 'POST',
            'action' => url()->current(),
            'enctype' => 'application/x-www-form-urlencoded'
        ];
        
        $this->config = array_merge($defaults, $config);
    }

    public function render()
    {
        return view('reactiform::components.form-open', ['config' => $this->config]);
    }
}