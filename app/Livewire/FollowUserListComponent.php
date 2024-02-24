<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class FollowUserListComponent extends Component
{
    public $users; // Lista de usuários a serem exibidos
    public $perPage = 3; // Quantidade de usuários por página
    public $page = 1; // Página atual
    public $showMoreButton = true; // Controla a exibição do botão "Show more"

    public function render()
    {
        // Carrega os usuários a serem exibidos
        $this->users = User::where('id', '!=', auth()->id())
            ->take($this->perPage * $this->page)
            ->get();

        // Oculta o botão "Show more" se não houver mais usuários a carregar
        if ($this->users->count() < ($this->perPage * $this->page)) {
            $this->showMoreButton = false;
        }

        return view('livewire.follow-user-list-component');
    }

    // Carrega mais usuários quando o botão "Show more" é clicado
    public function loadMore()
    {
        $this->page++;
    }

    // Segue um usuário
    public function followUser($userId)
    {
        $user = User::findOrFail($userId);
        auth()->user()->follow($user);
    }

    // Deixa de seguir um usuário
    public function unfollowUser($userId)
    {
        $user = User::findOrFail($userId);
        auth()->user()->unfollow($user);
    }
}
