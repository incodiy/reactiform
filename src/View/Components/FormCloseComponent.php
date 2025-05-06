<?php
namespace Incodiy\Reactiform\View\Components;

use Illuminate\View\Component;

class FormCloseComponent extends Component
{
    public $buttons;
    
    public function __construct($buttons = [])
    {
        $this->buttons = $buttons;
    }

    public function render()
    {
        return view('reactiform::components.form-close', ['buttons' => $this->buttons]);
    }
}