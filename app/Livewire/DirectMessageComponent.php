<?php

namespace App\Livewire;

use App\Models\DirectMessage;
use Livewire\Component;

class DirectMessageComponent extends Component
{
    public $recipientId;
    public $messages;
    public $content;

    protected $rules = [
        'content' => 'required|max:255',
    ];

    public function mount($recipientId)
    {
        $this->recipientId = $recipientId;
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.direct-message-component');
    }

    public function loadMessages()
    {
        $this->messages = DirectMessage::where(function ($query) {
            $query->where('sender_id', auth()->id())
                ->where('recipient_id', $this->recipientId);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->recipientId)
                ->where('recipient_id', auth()->id());
        })->orderBy('created_at')->get();
    }

    public function sendMessage()
    {
        $this->validate();

        DirectMessage::create([
            'sender_id' => auth()->id(),
            'recipient_id' => $this->recipientId,
            'content' => $this->content,
        ]);

        $this->content = '';

        $this->loadMessages();
    }
}
