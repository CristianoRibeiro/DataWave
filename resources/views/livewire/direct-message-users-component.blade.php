
<div>
    <h2>Usuários Disponíveis para Mensagens Diretas</h2>

    <ul>
        @foreach ($users as $user)
            <li>
                <a href="{{ route('direct-messages.show', $user->id) }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
</div>
