<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUserFormRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $users = $this->model->getUsers(search: $request->search ?? '');
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        /* primeira maneira de salvar, a mais verbosa */

        /* $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save(); */

        /* segunda maneira de salvar, mais produtiva (bcrypt inportante para criptografar a senha) */

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $this->model->create($data);
        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        return view('users.edit', compact('user'));
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {

        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        /* primeira maneira de salvar, a mais verbosa */

        /* $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->save();
        return redirect()->route('users.index'); */

        /* segunda maneira de atualizar, mais produtiva */

        $data = $request->only('name', 'email');
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        if (!$user = $this->model->find($id))
            return redirect()->route('users.index');

        $user->delete();

        return redirect()->route('users.index');
    }
}
