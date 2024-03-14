<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use App\Models\Employee;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Kelola User';
        $users = User::notAdmin()->get();
        $roles = Role::all();
        $work_units = WorkUnit::all();

        // Kirim data role ke view bersamaan dengan data users dan title
        return view('app.user', compact('users', 'title', 'roles', 'work_units'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'user_name' => 'required|max:255',
            'identity_number' => 'nullable|numeric',
            'user_email' => 'required|email|unique:users,email',
            'user_role' => 'required|exists:roles,name',
            'position' => 'string|required_if:identity_number,true',
            'work_unit' => 'integer|required_if:identity_number,true',
        ]);

        try {
            $randomPassword = Str::random(10);

            $user = User::create([
                'name' => $validatedData['user_name'],
                'email' => $validatedData['user_email'],
                'password' => Hash::make($randomPassword),
            ]);
            if (!empty($validatedData['identity_number']) && empty($validatedData['position'] && empty($validatedData['work_unit']))) {
                $employee = new Employee([
                    'id' => $validatedData['identity_number'],
                    'position' => $validatedData['position'],
                    'work_unit_id' => $validatedData['work_unit'],
                ]);
                $user->employee()->save($employee);
            }
            $user->assignRole($validatedData['user_role']);

            $user->save();

            // Kirim email dengan password yang digenerate
            // Mail::to($user->email)->send(new UserRegistered($user, $randomPassword));
            return back()->with('success', 'Data user berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => [
                'nullable',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
        ]);

        // Hanya enkripsi dan update password jika field password diisi
        if (!empty($request->password)) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']); // Jangan update password jika tidak diisi
        }

        $user->update($validatedData);

        // Respons untuk request AJAX
        if ($request->ajax()) {
            return response()->json(['success' => 'Data user berhasil diperbaharui.'], 200);
        }

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbaharui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }

    public function getUsers(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 10); // Default to 10 if not provided

        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('identity_number', 'LIKE', "%{$search}%");
        }

        $ppks = $query->limit($limit)->get(['id', 'name', 'identity_number']);

        return response()->json($ppks);
    }
}
