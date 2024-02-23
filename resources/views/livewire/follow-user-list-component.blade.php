<div>
    @if($users->count() > 0)
        <!-- Exibir usuários -->
            <div class="user-item bg-gray-50 dark:bg-dim-700 rounded-2xl m-2">
                <h1 class="text-gray-900 dark:text-white text-md font-bold p-3 border-b border-gray-200 dark:border-dim-200">Quem seguir?</h1>
                @foreach($users as $user)

                <div class="text-blue-400 text-sm font-normal p-3 border-b border-gray-200 dark:border-dim-200 hover:bg-gray-100 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">
                    <div class="flex flex-row justify-between p-2">
                        <div class="flex flex-row">
                            <img class="w-10 h-10 rounded-full" src="{{ $user->profile_photo_url  }}" alt="{{ $user->name }}" />
                            <div class="flex flex-col ml-2">
                                <h1 class="text-gray-900 dark:text-white font-bold text-sm">{{ $user->name }}</h1>
                                <p class="text-gray-400 text-sm">{{ explode('@', $user->email)[0] }}</p>
                            </div>
                        </div>
                        <div class="">
                            <div class="flex items-center h-full text-gray-800 dark:text-white">
                                @if(auth()->user()->isFollowing($user))
                                    <button wire:click="unfollowUser({{ $user->id }})"
                                        class="text-xs font-bold text-blue-400 px-4 py-1 rounded-full border-2 bg-blue-400 border-blue-400 text-white"> Deixar de Seguir</button>
                                @else
                                    <button wire:click="followUser({{ $user->id }})"
                                        class="text-xs font-bold text-blue-400 px-4 py-1 rounded-full border-2 border-blue-400">Seguir</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        <!-- Botão "Show more" -->
        @if($showMoreButton)
            <div wire:click="loadMore" class="show-more-button bg-gray-50 dark:bg-dim-700 rounded-2xl m-2 text-blue-400 text-sm font-normal p-3 hover:bg-gray-100 dark:hover:bg-dim-300 cursor-pointer transition duration-350 ease-in-out">Show more</div>
        @endif
    @else
        <div class="no-users-message">No users to display</div>
    @endif
</div>
