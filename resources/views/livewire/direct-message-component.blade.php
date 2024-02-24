<div>
    <h2>Mensagens Diretas com {{ $recipientId }}</h2>

    <div>
        @foreach ($messages as $message)
            <div>
                <strong>{{ $message->sender_id === auth()->id() ? 'Você' : $message->sender->name }}:</strong>
                {{ $message->content }}
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage">
        <textarea wire:model.defer="content" rows="3" cols="30"></textarea>
        @error('content') <span>{{ $message }}</span> @enderror
        <button type="submit">Enviar</button>
    </form>
</div>
