<?php

namespace App\Http\Controllers;

use App\Models\WorkUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MyProfileController extends Controller
{
    public function index()
    {
        $title = 'Profil Pengguna';
        $user = Auth::user()->load('roles'); // Eager load roles
        $workUnits = WorkUnit::all();

        return view('app.my-profile', compact('title', 'user', 'workUnits'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'identity_number' => 'required|numeric|unique:users,identity_number|digits_between:10,18',
            // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'work_unit_id' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle photo upload
        // if ($request->hasFile('photo')) {
        //     // Delete old photo if exists
        //     if ($user->photo && Storage::exists($user->photo)) {
        //         Storage::delete($user->photo);
        //     }

        //     $photoPath = $request->file('photo')->store('profile_photos', 'public');
        //     $user->photo = $photoPath;
        // }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->identity_number = $request->identity_number;
        $user->work_unit_id = $request->work_unit_id;
        $user->dob = $request->dob;
        $user->address = $request->address;
        $user->phone = $request->phone;

        $user->save();

        return redirect()->route('my-profile.index')->with('success', 'Profil berhasil diperbarui.');
    }
}
