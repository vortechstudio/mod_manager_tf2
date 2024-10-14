<?php

namespace App\Livewire\Core;

use Livewire\Component;

class Toast extends Component
{
    public $showToast = false;
    public $message = 'Notification!';
    public $type = 'success';
    protected $listeners = ['showToast'];

    public function showToast($type, $message)
    {
        $this->message = $message;
        $this->showToast = true;
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.core.toast');
    }
}
