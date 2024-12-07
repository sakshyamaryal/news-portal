<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function show(){
        $user = auth()->user();
        return view('users.showuserdetail', compact('user'));
    }

    public function edit(){
        $user = auth()->user();
        return view('users.edituserdetail', compact('user'));
    }

    public function update(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user's information
        $user = Auth::user();
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function uploadImage(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'profile_image' => 'required|image|max:5120',  // Maximum 5MB
        ]);

        $user = Auth::user();

        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imagePath = $image->store('profile_images', 'public'); // Store in 'storage/app/public/profile_images'

            // Delete old profile image if it exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Save the new image path to the user record
            $user->profile_image = $imagePath;
            $user->save();

            return response()->json(['message' => 'Profile image uploaded successfully!'], 200);
        }

        return response()->json(['message' => 'No image file provided.'], 400);
    }
}
