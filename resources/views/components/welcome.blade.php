<div class="flex flex-row justify-center">

  <!-- Middle -->
  <div class="w-full sm:w-600 h-screen">
    <!-- Header -->
    <div
      class="flex justify-between items-center border-b px-4 py-3 sticky top-0 bg-white dark:bg-dim-900 border-l border-r border-gray-200 dark:border-gray-700">
      <!-- Title -->
      <h2 class="text-gray-800 dark:text-gray-100 font-bold font-sm">
        Home
      </h2>
      <!-- /Title -->
      <!-- Custom Timeline -->
      <div>
        <svg viewBox="0 0 24 24" class="w-5 h-5 text-blue-400" fill="currentColor">
          <g>
            <path
              d="M22.772 10.506l-5.618-2.192-2.16-6.5c-.102-.307-.39-.514-.712-.514s-.61.207-.712.513l-2.16 6.5-5.62 2.192c-.287.112-.477.39-.477.7s.19.585.478.698l5.62 2.192 2.16 6.5c.102.306.39.513.712.513s.61-.207.712-.513l2.16-6.5 5.62-2.192c.287-.112.477-.39.477-.7s-.19-.585-.478-.697zm-6.49 2.32c-.208.08-.37.25-.44.46l-1.56 4.695-1.56-4.693c-.07-.21-.23-.38-.438-.462l-4.155-1.62 4.154-1.622c.208-.08.37-.25.44-.462l1.56-4.693 1.56 4.694c.07.212.23.382.438.463l4.155 1.62-4.155 1.622zM6.663 3.812h-1.88V2.05c0-.414-.337-.75-.75-.75s-.75.336-.75.75v1.762H1.5c-.414 0-.75.336-.75.75s.336.75.75.75h1.782v1.762c0 .414.336.75.75.75s.75-.336.75-.75V5.312h1.88c.415 0 .75-.336.75-.75s-.335-.75-.75-.75zm2.535 15.622h-1.1v-1.016c0-.414-.335-.75-.75-.75s-.75.336-.75.75v1.016H5.57c-.414 0-.75.336-.75.75s.336.75.75.75H6.6v1.016c0 .414.335.75.75.75s.75-.336.75-.75v-1.016h1.098c.414 0 .75-.336.75-.75s-.336-.75-.75-.75z">
            </path>
          </g>
        </svg>
      </div>
      <!-- /Custom Timeline -->
    </div>
    <!-- /Header -->
    @livewire('toast-component')

    <!-- Post Tweet -->
    <div id="tweet-component">
      @livewire('tweet-component')
    </div>
    <!-- /Post Tweet -->

    <!-- Timeline -->



    <!-- Tweet -->

    @livewire('tweet-list-component')



    <!-- /Tweet -->




    <!-- /Timeline -->
  </div>
  <!-- /Middle -->

  <!-- Right -->
  <div class="hidden md:block w-290 lg:w-350 h-screen">
    <div class="flex flex-col fixed overflow-y-auto w-290 lg:w-350 h-screen">
      <!-- Search -->
      @livewire('search-component')
      <!-- /Search -->



      <!-- Who to follow -->
      @livewire('follow-user-list-component')
      <!-- /Who to follow -->

      <footer>
        <ul class="text-xs text-gray-500 my-4 mx-2">
          <li class="inline-block mx-2">
            <a class="hover:underline" href="#">Terms of Service</a>
          </li>
          <li class="inline-block mx-2">
            <a class="hover:underline" href="#">Privacy Policy</a>
          </li>
          <li class="inline-block mx-2">
            <a class="hover:underline" href="#">Cookie Policy</a>
          </li>
          <li class="inline-block mx-2">
            <a class="hover:underline" href="#">Ads info</a>
          </li>
          <li class="inline-block mx-2">
            <a class="hover:underline" href="#">More</a>
          </li>
          <li class="inline-block mx-2">© 2020 Twitter, Inc.</li>
        </ul>
      </footer>
    </div>
  </div>
  <!-- /Right -->
  <script>
    // Escuta o evento 'hideTweetComponent' e oculta o componente TweetComponent
        document.addEventListener('livewire:init', () => {
          Livewire.on('hideTweetComponent', () => {
            document.getElementById('tweet-component').style.display = 'none';
        });
        });
</script>


</div>