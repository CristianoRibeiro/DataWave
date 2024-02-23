<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class FollowUserListComponent extends Component
{
    public $users;
    public $perPage = 3;
    public $page = 1;
    public $showMoreButton = true;

    public function render()
    {
        // Verificar se existem usuários a serem exibidos
        $this->users = User::where('id', '!=', auth()->id())
            ->take($this->perPage * $this->page)
            ->get();

        // Ocultar o botão "Show more" se não houver mais usuários a carregar
        if ($this->users->count() < ($this->perPage * $this->page)) {
            $this->showMoreButton = false;
        }

        return view('livewire.follow-user-list-component');
    }

    public function loadMore()
    {
        $this->page++;
    }

    public function followUser($userId)
    {
        $user = User::findOrFail($userId);
        auth()->user()->follow($user);
    }

    public function unfollowUser($userId)
    {
        $user = User::findOrFail($userId);
        auth()->user()->unfollow($user);
    }
}
