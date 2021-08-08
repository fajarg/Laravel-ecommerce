<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.user.user', compact('users'));
    }

    public function insert()
    {
        return view('admin.user.insert');
    }

    public function insertAction(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $email_verified_at = now();
        $remember_token = Str::random(10);

        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->email_verified_at = $email_verified_at;
        $user->remember_token = $remember_token;
        $user->save();

        return back()->with('status', 'Data updated!');
    }

    public function edit($id)
    {
        $users = User::find($id);
        return view('admin.user.edit', compact('users'));
    }

    public function editAction(Request $request, $id)
    {
        $user = User::find($id);
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
        ]);

        $nama = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');


        $user->id = $id;
        $user->name = $nama;
        $user->email = $email;
        if (isset($password)) {
            $user->password = Hash::make($password);
        }
        $user->password = $user->password;
        $user->save();

        return back()->with('status', 'Data was updated!');
    }

    public function delete($id)
    {
        $deleteProduct = User::find($id);
        $deleteProduct->delete();

        return back()->with('status', 'Data was deleted!');
    }
}
