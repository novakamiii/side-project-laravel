<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __invoke(Request $request)
    {
        // This gets the currently authenticated user session
        $user = Auth::user();

        return view('user-profile', compact('user'));
    }

    public function changeDetails(Request $request)
    {
        $userData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . Auth::id()],
            'phone_number' => ['required', 'string', 'max:11'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::id()],
            'address' => ['required', 'string'],
        ]);

        $user = Auth::user();

        $user->update($userData);

        return redirect()->route('profile.show')->with('status', 'Profile updated successfully!');
    }

    public function changeProfilePicture(Request $request)
    {
        // 1. Validate (Added 'image' rule for safety)
        $request->validate([
            'prof_img' => ['required', 'image', 'max:2048']
        ]);

        $user = Auth::user();

        // 2. Only upload if a file exists
        if ($request->hasFile('prof_img')) {
            $path = $this->uploadProfilePicture(
                $request->file('prof_img'),
                $user->prof_img
            );

            $user->update(['prof_img' => $path]);
        }

        return redirect()->route('profile.show')->with('status', 'Profile picture updated!');
    }

    private function uploadProfilePicture($file, $oldPath = null): string
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $file->store('profiles', 'public');
    }
}
