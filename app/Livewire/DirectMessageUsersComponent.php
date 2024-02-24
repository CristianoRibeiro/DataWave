
<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class DirectMessageUsersComponent extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('id', '!=', auth()->id())->get();
    }

    public function render()
    {
        return view('livewire.direct-message-users-component');
    }
}
