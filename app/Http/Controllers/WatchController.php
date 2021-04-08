<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\watchlist;
use Illuminate\Support\Facades\DB;

class WatchController extends Controller
{
    public function listWatchlists()
    {
        // Modèle
        $userID = Auth::id();

        $watchlists = DB::table('watchlists')
                    ->join('animes', 'watchlists.anime_id', '=', 'animes.id')
                    ->join('users', 'watchlists.user_id', '=', 'users.id')
                    ->where('user_id', '=', $userID)
                    ->get();

        return view('watchlist', ["animes" => $watchlists]);
    }

    public function addInWatchlist($id)
    {
        $userID = Auth::id();

        // enregistrement des données dans la BDD
        $newAnimeInWL = new watchlist();
        $newAnimeInWL->user_id = $userID;
        $newAnimeInWL->anime_id = $id;
        $newAnimeInWL->save();

        return redirect('/watchlist/');
    }

    public function deleteAnimeFromWatchlist($id)
    {
        $userID = Auth::id();

        $deleteAnimeFromWL = DB::table('watchlists')
                            ->where('anime_id', '=', $id)
                            ->where('user_id', '=', $userID)
                            ->delete();
        
        return redirect('watchlist');
    }
}
