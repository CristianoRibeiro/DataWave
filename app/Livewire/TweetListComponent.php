<?php

namespace App\Livewire;

use App\Models\Tweet;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TweetListComponent extends Component
{
    use WithPagination;

    public $totalTweets = 0;
    public $tweetsPerPage = 1;
    public $selectedHashtag = null;
    public $showTweetComponent = true;
    public $searchTerm = '';

    // Define os listeners para os eventos emitidos
    protected $listeners = ['tweet-created' => '$refresh', 'searchTriggered'];

    public function mount()
    {
        // Conta o total de tweets
        $this->totalTweets = Tweet::count();
    }

    public function render()
    {
        // Renderiza a view 'livewire.tweet-list-component' com os tweets e o status do componente
        return view('livewire.tweet-list-component', [
            'tweets' => $this->getTweets(),
            'showTweetComponent' => $this->showTweetComponent,
        ]);
    }

    protected function getTweets()
    {
        // Retorna os tweets com base no filtro selecionado
        if ($this->selectedHashtag) {
            return $this->loadTweetsByHashtag();
        }

        if (!empty($this->searchTerm)) {
            return $this->loadTweetsBySearchTerm();
        }

        // Retorna os tweets mais recentes paginados
        return Tweet::latest()->paginate($this->tweetsPerPage);
    }

    protected function loadTweetsByHashtag()
    {
        // Carrega os tweets com base na hashtag selecionada
        $tweets = Tweet::where('content', 'like', "%$this->selectedHashtag%")
            ->orWhereHas('hashtags', function ($query) {
                $query->where('name', 'like', "%$this->selectedHashtag%");
            })
            ->paginate($this->tweetsPerPage);

        return $this->transformTweets($tweets);
    }

    protected function loadTweetsBySearchTerm()
    {
        // Carrega os tweets com base no termo de pesquisa
        $tweets = Tweet::where('content', 'like', "%{$this->searchTerm}%")
            ->orWhereHas('hashtags', function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->paginate($this->tweetsPerPage);

        return $this->transformTweets($tweets);
    }

    protected function transformTweets($tweets)
    {
        // Transforma os tweets processando as hashtags
        return $tweets->transform(function ($tweet) {
            $tweet->content = $this->processHashtags($tweet->content);
            return $tweet;
        });
    }

    protected function processHashtags($content)
    {
        // Processa as hashtags no conteúdo do tweet e as substitui por links
        return preg_replace_callback('/#(\w+)/', function ($matches) {
            $tag = $matches[1];
            $hashtag = Str::lower($tag);
            return "<a href=\"#\" wire:click.prevent=\"showHashtag('{$hashtag}')\" class=\"hashtag\">#$tag</a>";
        }, $content);
    }

    public function loadMoreTweets()
    {
        // Carrega mais tweets aumentando a quantidade por página
        $this->tweetsPerPage += 2;
    }

    public function showHashtag($hashtag)
    {
        // Define a hashtag selecionada e oculta o componente de tweet
        $this->selectedHashtag = $hashtag;
        $this->showTweetComponent = false;
        $this->dispatch('hideTweetComponent');
    }

    public function searchTriggered($term)
    {
        // Atualiza o termo de pesquisa
        $this->searchTerm = $term;
    }
}
