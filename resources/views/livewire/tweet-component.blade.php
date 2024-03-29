<!-- app/Livewire/TweetComponent.php -->

<div class="border-b border-gray-200 pb-4 border-l border-r">
    <form wire:submit.prevent="createTweet" enctype="multipart/form-data">
        <div class="flex flex-shrink-0 p-4 pb-0">
            <div class="w-12 flex items-top">
                <img class="inline-block h-10 w-10 rounded-full" src="https://pbs.twimg.com/profile_images/1308769664240160770/AfgzWVE7_normal.jpg" alt="" />
            </div>
            <div class="w-full p-2">
                <textarea wire:model.defer="content" class="dark:text-white text-gray-900 placeholder-gray-400 w-full h-10 bg-transparent border-0 focus:outline-none resize-none" placeholder="O que está acontecendo?"></textarea>
                @error('content') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="w-full flex items-top p-2 text-white pl-14">
            <label class="uploadMediaTwitter text-blue-400"> 
                <input type="file" wire:model="media" class="text-blue-400 hover:bg-blue-50 rounded-full p-2">
                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="currentColor">
                    <g>
                        <path d="M19.75 2H4.25C3.01 2 2 3.01 2 4.25v15.5C2 20.99 3.01 22 4.25 22h15.5c1.24 0 2.25-1.01 2.25-2.25V4.25C22 3.01 20.99 2 19.75 2zM4.25 3.5h15.5c.413 0 .75.337.75.75v9.676l-3.858-3.858c-.14-.14-.33-.22-.53-.22h-.003c-.2 0-.393.08-.532.224l-4.317 4.384-1.813-1.806c-.14-.14-.33-.22-.53-.22-.193-.03-.395.08-.535.227L3.5 17.642V4.25c0-.413.337-.75.75-.75zm-.744 16.28l5.418-5.534 6.282 6.254H4.25c-.402 0-.727-.322-.744-.72zm16.244.72h-2.42l-5.007-4.987 3.792-3.85 4.385 4.384v3.703c0 .413-.337.75-.75.75z"></path>
                        <circle cx="8.868" cy="8.309" r="1.542"></circle>
                    </g>
                </svg>
            </label>

            <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white rounded-full py-1 px-4 ml-auto mr-1">
                <span class="font-bold text-sm">Tweet</span>
            </button>
        </div>
    </form>
</div>
