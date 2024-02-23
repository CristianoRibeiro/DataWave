<?php

namespace App\Livewire;

use Livewire\Component;

class ToastComponent extends Component
{
    public $tweetType;
    public $message;

    protected $listeners = ['toast'];

    public function toast($data)
    {
        $this->tweetType = $data['tweetType'];
        $this->message = $data['message'];
    }

    public function render()
    {
        return view('components.toast-component');
    }
}
