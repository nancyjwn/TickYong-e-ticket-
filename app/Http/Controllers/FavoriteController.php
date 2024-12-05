<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to add to favorites.');
        }
        
        $request->validate([
            'event_id' => 'required|exists:events,id',
        ]);

        // Check if the favorite already exists
        $existingFavorite = Favorite::where('user_id', Auth::id())
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingFavorite) {
            return back()->with('error', 'Event is already in your favorites!');
        }

        // Add to favorites if it doesn't exist
        Favorite::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
        ]);

        return back()->with('success', 'Event added to favorites!');
    }
}
