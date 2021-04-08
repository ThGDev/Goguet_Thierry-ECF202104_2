<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class topController extends Controller
{
    public function listTop()
    {
        $topAnimes = DB::table('reviews')
                        ->join('animes', 'reviews.anime_id', '=', 'animes.id')
                        // ici on sélectionne la colonne "rating" dans la table "reviews" et on fait la moyenne des notes
                        ->select('title',\DB::raw("avg(rating) as moyenne"), 'description', 'cover', 'anime_id', 'user_id')
                        ->groupBy('anime_id')
                        ->orderBy('moyenne', 'desc')
                        ->get();
        
        $memberRatings = DB::table('reviews')
                            ->join('users', 'reviews.user_id', '=', 'users.id')
                            ->select('rating', 'username', 'anime_id')
                            ->groupBy('anime_id', 'username')
                            ->get();
        // dd($memberRatings);
        // Va nous servir dans la vue pour incrémenter le chiffre (pour écrire le numéro de classement de l'anime...)
        $rank = 1;

        return view('top', [
            'animes' => $topAnimes,
            'memberRatings' => $memberRatings,
            'rank' => $rank
            ]);
    }
}
