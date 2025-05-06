<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class TextComponent extends Component
{
    public $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render()
    {
        return view('reactiform::components.text', ['config' => $this->config]);
    }
}