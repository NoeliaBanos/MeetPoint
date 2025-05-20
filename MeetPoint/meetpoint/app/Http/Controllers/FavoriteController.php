<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Espacio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Añade un espacio a favoritos (vía AJAX).
     */
    public function store(Espacio $espacio)
    {
        /** @var User $user */
        $user = Auth::user();
        // Comprueba en el modelo User que exista hasFavorited()
        if (! $user->hasFavorited($espacio)) {
            Favorite::create([
                'user_id'    => $user->id,
                'espacio_id' => $espacio->id,
            ]);
        }

        return response()->json([
            'status' => 'favorited',
            'count'  => $espacio->favoritedBy()->count(),
        ]);
    }

    /**
     * Quita un espacio de favoritos (vía AJAX).
     */
    public function destroy(Espacio $espacio)
    {
        $user = Auth::user();

        Favorite::where('user_id', $user->id)
            ->where('espacio_id', $espacio->id)
            ->delete();

        return response()->json([
            'status' => 'unfavorited',
            'count'  => $espacio->favoritedBy()->count(),
        ]);
    }
}
