<?php

namespace App\Livewire;

use App\Models\Tweet;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TweetListComponent extends Component
{
    use WithPagination;

    public $tweetsPerPage = 1;
    public $isScrollLoading = false;
    public $totalTweets;
    public $selectedHashtag = null;
    public $showTweetComponent = true;
    public $searchTerm = '';

    protected $listeners = ['tweet-created' => '$refresh', 'searchTriggered'];

    public function mount()
    {
        $this->totalTweets = Tweet::count();
    }

    public function render()
    {
        if ($this->selectedHashtag) {
            $this->showTweetComponent = false;
            return $this->loadTweetsByHashtag($this->selectedHashtag);
        }

        if (!empty($this->searchTerm)) {
            $this->showTweetComponent = true; // Mostra o componente TweetComponent

            return $this->loadTweetsBySearchTerm();
        }

        $tweets = Tweet::latest()->paginate($this->tweetsPerPage);

        $tweets->transform(function ($tweet) {
            $this->processHashtags($tweet);
            return $tweet;
        });

        return view('livewire.tweet-list-component', [
            'tweets' => $tweets,
            'showTweetComponent' => $this->showTweetComponent,
        ]);
    }

    protected function processHashtags($tweet)
    {
        preg_match_all('/#(\w+)/', $tweet->content, $matches);
        $hashtags = collect($matches[1])->unique();
        foreach ($hashtags as $tag) {
            $hashtag = Str::lower($tag);
            $tweet->content = str_replace("#$tag", "<a href=\"#\" wire:click.prevent=\"showHashtag('{$hashtag}')\" class=\"hashtag\">#$tag</a>", $tweet->content);
        }
    }

    public function loadMoreTweets()
    {
        $this->tweetsPerPage += 2;
    }

    public function loadTweetsByHashtag($hashtag)
    {
        $tweets = Tweet::where('content', 'like', "%$hashtag%")
            ->orWhereHas('hashtags', function ($query) use ($hashtag) {
                $query->where('name', 'like', "%$hashtag%");
            })
            ->paginate($this->tweetsPerPage);

        $tweets->transform(function ($tweet) {
            $this->processHashtags($tweet);
            return $tweet;
        });

        return view('livewire.tweet-list-component', [
            'tweets' => $tweets,
            'showTweetComponent' => $this->showTweetComponent,
        ]);
    }

    public function showHashtag($hashtag)
    {
        $this->selectedHashtag = $hashtag;
        $this->showTweetComponent = false;
        $this->dispatch('hideTweetComponent');
        $this->render();
    }

    public function updated()
    {
        if ($this->isScrollLoading && $this->tweets->count() >= $this->totalTweets) {
            $this->isScrollLoading = false;
        }
    }

    public function searchTriggered($term)
    {
        $this->searchTerm = $term;
    }

    public function loadTweetsBySearchTerm()
    {
        $tweets = Tweet::where('content', 'like', "%{$this->searchTerm}%")
            ->orWhereHas('hashtags', function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orWhereHas('user', function ($query) {
                $query->where('email', 'like', '%' . $this->searchTerm . '%');
            })
            ->paginate($this->tweetsPerPage);

        $tweets->transform(function ($tweet) {
            $this->processHashtags($tweet);
            return $tweet;
        });

        return view('livewire.tweet-list-component', [
            'tweets' => $tweets,
            'showTweetComponent' => $this->showTweetComponent,
        ]);
    }
}
