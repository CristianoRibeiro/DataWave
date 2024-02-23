<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tweet;
use App\Models\User;

class SearchComponent extends Component
{
    public $searchTerm;

    public function executeSearch()
    {
        // Emitir evento para pesquisar apenas quando o usuário pressionar Enter ou parar de digitar
        $this->dispatch('searchTriggered', $this->searchTerm);
    }

    public function render()
    {
        return view('livewire.search-component');
    }
}
