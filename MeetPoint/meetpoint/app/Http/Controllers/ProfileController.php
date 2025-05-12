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
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Obtener el usuario autenticado
        $user = $request->user();

        // Rellenar con los datos validados
        $user->fill($request->validated());

        // Si cambia el email, "desverificarlo"
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardar cambios
        $user->save();

        // Redirigir a la página de perfil con mensaje de éxito
        return Redirect::route('profile.show')
            ->with('status', 'Perfil actualizado con éxito.');
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
  public function show(Request $request): View
{
    return view('profile.show', [
        'user' => $request->user(),
    ]);
}

    /**
     * Actualizar la contraseña
     */
    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password'      => ['required', 'current_password'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('status', 'Contraseña actualizada con éxito.');
    }
}
