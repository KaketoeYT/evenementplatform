<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRoleRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('settings.profile', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return to_route('settings.profile.edit')->with('status', __('Profile updated successfully'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home');
    }

    public function user_view()
    {
        $users = User::all();

        return view('administrator.user_view', compact('users'));
    }

    public function update_roles(UpdateRoleRequest $request)
    {
        foreach ($request->roles as $userId => $role) {
            User::where('id', $userId)->update(['role' => $role]);
        }

        return redirect()->route('administrator.user.view')->with('status', 'Rollen bijgewerkt!');
    }

    public function deactivate_user($userId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        $user->status = $user->status === 'active' ? 'deactive' : 'active';
        $user->save();

        $action = $user->status === 'active' ? 'geactiveerd' : 'gedeactiveerd';

        return redirect()->route('administrator.user.view')->with('status', 'Gebruiker '.$action.'!');
    }

    public function sendPasswordResetMail($userId): RedirectResponse
    {
        $user = User::findOrFail($userId);

        // Genereer een reset token
        $token = Password::createToken($user);

        // Verstuur de mail
        Mail::to($user->email)->send(new PasswordResetMail($token, $user->email));

        return redirect()->route('administrator.user.view')->with('status', 'Wachtwoord reset mail verstuurd naar '.$user->email);
    }
}
