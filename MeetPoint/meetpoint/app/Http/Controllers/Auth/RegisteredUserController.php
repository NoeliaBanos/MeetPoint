<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


use Illuminate\Database\QueryException;


class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)],
        ]);

        try {
            $user = User::create([
                'name'     => $request->name,
                'apellidos' => $request->apellidos,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
        } catch (QueryException $e) {
            return back()
                ->withInput($request->only('name', 'apellidos', 'email'))
                ->withErrors([
                    'general' => 'No se ha podido crear la cuenta. Por favor, inténtalo de nuevo más tarde.'
                ]);
        }

        if (! $user instanceof User) {
            return back()
                ->withInput($request->only('name', 'apellidos', 'email'))
                ->withErrors([
                    'general' => 'Ocurrió un error inesperado. No se creó el usuario.'
                ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('index'));
    }
}
