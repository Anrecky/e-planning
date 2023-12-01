<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $title = "Kelola User";
        $users = User::all();
        return view('app.user', compact('users', 'title'));
    }
    public function store(Request $request)
    {
        foreach ($request->user_name as $index => $name) {
            $validator = Validator::make([
                'name' => $name,
                'email' => $request->user_email[$index],
                'password' => $request->user_password[$index],
            ], [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = new User;
            $user->name = $name;
            $user->email = $request->user_email[$index];
            $user->password = bcrypt($request->user_password[$index]);
            $user->save();
        }

        return redirect()->route('user.index')->with('success', 'Users created successfully.');
    }
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->update($validatedData);

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
