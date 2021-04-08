<?php

namespace App\Http\Controllers;

use App\Models\anime;
use Illuminate\Support\Facades\DB;

class AnimeController extends Controller
{
    public function listAnimes()
    {
        // Modèle
        // On regarde dans le modèle "anime" et on récupère tous les animes trouvés
        $animes = anime::all();
        // Vue
        return view('welcome', ["animes" => $animes]);
    }

    public function viewAnimeAndReviews($id)
    {
        // Modèle
        // On va regarder dans le modèle "anime" ou l'id = $id et on affiche le résultat correspondant
        $anime = anime::whereId($id)->first();
        
        // On va maintenant joindre les tables "reviews"/"animes"/"users" pour lister nos critiques et pouvoir utiliser le "rating" et le "username" de la personne qui a laissé une critique sur l'anime concerné
        $reviews = DB::table('reviews')
                ->join('animes', 'reviews.anime_id', '=', 'animes.id')
                ->where('reviews.anime_id', $id)
                ->join('users', 'reviews.user_id', '=', 'users.id')
                ->get();

        // Calcul de la moyenne à une décimale
        // On peut voir dans le TopController qu'il y a d'autre méthodes, je teste différentes manières de faire...
        $animeAverageFull = $reviews->avg('rating');
        $animeAverage = number_format((float)$animeAverageFull, 1, '.', '');

        // Vue
        // On envoie dans la vue "anime.blade.php" les résultats de notre query
        return view('anime', [
            "anime" => $anime,
            "critiques" => $reviews,
            "moyenne" => $animeAverage
            ]);
    }
}
