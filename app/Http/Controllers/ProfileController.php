<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

    public function index()
    {
        return view('account.index', [
            'user' => Auth::user()->load('info'),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function editInf(Request $request): View
    {
        return view('account.editInf', [
            'user' => $request->user()->load('info'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updateInf(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string|max:255',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'password' => 'nullable|string|confirmed|min:8',
        ]);

        $user = Auth::user();

        // Оновлення даних користувача
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();



        if ($user->info) {
            $user->info->update($request->only([
                'first_name',
                'last_name',
                'birthday',
                'phone',
                'address_line1',
                'address_line2',
                'city',
                'postal_code',
                'country',
            ]));
        } else {
            $user->info()->create($request->only([
                'first_name',
                'last_name',
                'birthday',
                'phone',
                'address_line1',
                'address_line2',
                'city',
                'postal_code',
                'country',
            ]));
        }


        return redirect()->route('account.index')->with('success', 'Profile updated successfully.');
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
