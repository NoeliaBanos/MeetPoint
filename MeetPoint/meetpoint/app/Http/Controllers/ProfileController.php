<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /* ─────────── Ver perfil ─────────── */
    public function show(Request $request): View
    {
        return view('profile.show', ['user' => $request->user()]);
    }

    /* ─────────── Formulario de edición ─────────── */
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    /* ─────────── Actualizar datos básicos ─────────── */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user      = $request->user();
        $validated = $request->validated();   // name, apellidos, email, avatar

        /* Avatar */
        if ($request->hasFile('avatar')) {
            // Borrar la foto previa
            if ($user->imagen_url && Storage::disk('userpics')->exists($user->imagen_url)) {
                Storage::disk('userpics')->delete($user->imagen_url);
            }

            // Guardar la nueva
            $filename = time().'.'.$request->file('avatar')->extension();
            Storage::disk('userpics')->putFileAs('', $request->file('avatar'), $filename);

            $validated['imagen_url'] = $filename; // solo el nombre
        }

        /* Resto de campos */
        $user->fill($validated);

        // Si cambió el correo, anular verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.show')
            ->with('status', 'Perfil actualizado con éxito.');
    }

    /* ─────────── Formulario: cambiar contraseña ─────────── */
    public function editPassword(): View
    {
        return view('profile.partials.edit-password');
    }

    /* ─────────── Actualizar contraseña ─────────── */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Cast 'hashed' en el modelo User gestiona el hash
        $request->user()->update(['password' => $request->password]);

        return Redirect::route('profile.show')
            ->with('status', 'Contraseña actualizada con éxito.');
    }

    /* ─────────── Eliminar cuenta ─────────── */
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
