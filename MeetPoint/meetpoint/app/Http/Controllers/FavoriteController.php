<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Espacio;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Espacio $espacio)
    {
        if (! Auth::check()) {
            abort(403);
        }
        if (! Auth::user()->hasFavorited($espacio)) {
            Favorite::create([
                'user_id'    => Auth::id(),
                'espacio_id' => $espacio->id,
            ]);
        }
        return back();
    }

    public function destroy(Espacio $espacio)
    {
        if (! Auth::check()) {
            abort(403);
        }
        Favorite::where('user_id', Auth::id())
                ->where('espacio_id', $espacio->id)
                ->delete();
        return back();
    }
}
