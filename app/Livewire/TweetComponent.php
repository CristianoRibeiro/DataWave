<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tweet;
use App\Models\Hashtag;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class TweetComponent extends Component
{
    use WithFileUploads;

    public $content;
    public $media;

    public function render()
    {
        $tweets = Tweet::with('hashtags')->latest()->get();
        return view('livewire.tweet-component', compact('tweets'));
    }

    public function createTweet()
    {
        $this->validate([
            'content' => 'required',
            'media' => '',
        ]);


        // Salvar o tweet
        $tweet = new Tweet();
        $tweet->user_id = auth()->id();
        $tweet->content = $this->content;

        if ($this->media) {
            $tweet->media = $this->media->store('media', 'public');
        }

        $tweet->save();

        // Extrair e salvar as hashtags mencionadas no tweet
        preg_match_all('/#(\w+)/', $this->content, $matches);
        $hashtags = collect($matches[1])->unique();
        foreach ($hashtags as $tag) {
            $hashtagName = '#' . Str::lower($tag); // Adiciona o # à hashtag
            $hashtag = Hashtag::firstOrCreate(['name' => $hashtagName]); // Salva a hashtag se ainda não existir
            $hashtag->increment('count'); // Incrementa a contagem de uso da hashtag

            // Associa a hashtag ao tweet na tabela pivot
            $tweet->hashtags()->attach($hashtag->id);

            // Substituir a hashtag no conteúdo do tweet por um link
            $tweet->content = str_replace("#$tag", "<a href=\"#\" wire:click.prevent=\"showHashtag('{$tag}')\" class=\"hashtag-link\">$hashtagName</a>", $tweet->content);
        }


        $tweet->save();

        $this->content = '';
        $this->media = null;

        if ($tweet) {
            $this->dispatch('toast', ['tweetType' => 'success', 'message' => 'Tweet criado com sucesso!']);
            $this->dispatch('tweet-created'); // Emitir evento para notificar a atualização da lista de tweets
        } else {
            $this->dispatch('toast', ['tweetType' => 'error', 'message' => 'Erro ao criar o tweet. Por favor, tente novamente.']);
        }
    }
}
