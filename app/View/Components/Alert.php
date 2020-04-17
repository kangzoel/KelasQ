<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type = 'danger';
    public $content = '';
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '')
    {
        $this->class = $class;

        if ($msg = session('message')) {
            $this->type = $msg['type'];
            $this->content = $msg['content'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.alert');
    }
}
