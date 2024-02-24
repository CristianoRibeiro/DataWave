<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tweet;
use App\Models\Hashtag;
use Illuminate\Support\Str;
use App\Http\Requests\CreateTweetRequest;
use Livewire\WithFileUploads;

class TweetComponent extends Component
{
    use WithFileUploads;

    public $content;
    public $media;

    // Renderiza o componente com os tweets mais recentes
    public function render()
    {
        $tweets = Tweet::with('hashtags')->latest()->get();
        return view('livewire.tweet-component', compact('tweets'));
    }

    // Cria um novo tweet
    public function createTweet(CreateTweetRequest $request)
    {
        // Valida os dados do formulário
        $validatedData = $request->validated();

        // Cria um novo tweet com os dados validados
        $tweet = new Tweet([
            'user_id' => auth()->id(),
            'content' => $validatedData['content'],
        ]);

        // Salva a mídia associada ao tweet, se existir
        if ($this->media) {
            $tweet->media = $this->media->store('media', 'public');
        }

        // Salva o tweet no banco de dados
        $tweet->save();

        // Processa as hashtags no conteúdo do tweet
        $this->processHashtags($tweet);

        // Limpa os campos do formulário
        $this->resetFields();

        // Exibe uma mensagem de sucesso
        $this->dispatchToast('success', 'Tweet criado com sucesso!');

        // Emite um evento para atualizar a lista de tweets
        $this->emit('tweet-created');
    }

    // Processa as hashtags no conteúdo do tweet
    private function processHashtags(Tweet $tweet)
    {
        preg_match_all('/#(\w+)/', $this->content, $matches);
        $hashtags = collect($matches[1])->unique();

        foreach ($hashtags as $tag) {
            $hashtagName = '#' . Str::lower($tag);
            $hashtag = Hashtag::firstOrCreate(['name' => $hashtagName]);
            $hashtag->increment('count');
            $tweet->hashtags()->attach($hashtag->id);
            $this->replaceHashtagWithLink($tweet, $tag, $hashtagName);
        }

        $tweet->save();
    }

    // Substitui as hashtags no conteúdo do tweet por links
    private function replaceHashtagWithLink(Tweet $tweet, $tag, $hashtagName)
    {
        $tweet->content = str_replace(
            "#$tag",
            "<a href=\"#\" wire:click.prevent=\"showHashtag('{$tag}')\" class=\"hashtag-link\">$hashtagName</a>",
            $tweet->content
        );
    }

    // Reseta os campos do formulário
    private function resetFields()
    {
        $this->content = '';
        $this->media = null;
    }

    // Dispara um evento para exibir uma mensagem de alerta
    private function dispatchToast($type, $message)
    {
        $this->dispatch('toast', ['tweetType' => $type, 'message' => $message]);
    }
}
