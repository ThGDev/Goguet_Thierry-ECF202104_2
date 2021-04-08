<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\review;
use App\Models\anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function nameOfAnime($id)
    {
        // pour récuperer et afficher le nom de l'anime
        $anime = anime::whereId($id)->first();

        return view('new_review', ["anime" => $anime]);
    }

    public function addReview(Request $request)
    {
        // validation des données reçues
        $validatedData = $request->validate([
            "rating" => "required",
            "comment" => "required",
            "animeID" => "required"
            ]);
        
        // enregistrement des données dans la BDD
        // Toujours pareil, il n'y a pas qu'une manière de faire, je teste...
        $review = new review();
        $review->rating = $validatedData['rating'];
        $review->comment = $validatedData['comment'];
        $review->user_id = Auth::id();
        $review->anime_id = $validatedData['animeID'];
        $review->save();

        return redirect('/anime/'.$validatedData['animeID']);
    }
}
