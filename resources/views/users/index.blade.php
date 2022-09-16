<h1>Listagem de usuários</h1>

<ul>

@foreach ($users as $user)
    <li>
       {{ $user->name }} -
       {{ $user->email }} -
       <a href="{{route('users.show', ['id' => $user->id])}}">Detalhes</a>
    </li>
@endforeach

</ul>
