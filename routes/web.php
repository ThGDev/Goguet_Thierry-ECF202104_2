<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WatchController;
use App\Http\Controllers\TopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
/ -------------- LES ANIMES
*/
// Liste les animes
Route::get('/', [AnimeController::class, 'listAnimes']);

// Affiche la page d'un anime selon son ID passé en paramètre de l'URL
Route::get('/anime/{id}', [AnimeController::class, 'viewAnimeAndReviews']);

/*
/ -------------- LES REVIEWS
*/

// Contrôle si un visiteur est connecté ou non pour laisser une critique
Route::get('/anime/{id}/add_review', [AuthController::class, 'addReviewIfConnected']);

// Pour aller sur la page de rédaction de critique
Route::get('/anime/{id}/new_review', [ReviewController::class, 'nameOfAnime']);

// Pour enregistrer sa critique
Route::post('/anime/{id}/record_review', [ReviewController::class, 'addReview']);

/*
/ -------------- LES WATCHLISTS
*/

// Contrôle si un visiteur est connecté ou non pour mettre un anime dans sa watchlist
Route::get('/anime/{id}/add_to_watch_list', [AuthController::class, 'addToWatchlistIfConnected']);

// Pour enregistrer un anime dans sa watchlist
// Route::post('/anime/{id}/new_anime_in_wl', [WatchController::class, 'addInWatchlist']);
Route::any('/insert_to_watch_list/{id}', [WatchController::class, 'addInWatchlist']);

// Pour aller sur la page des watchlists
Route::get('/watchlist/', [WatchController::class, 'listWatchlists']);

// Pour supprimer un anime de la watchlist
Route::get('/watchlist/delete/{id}', [WatchController::class, 'deleteAnimeFromWatchlist']);

/*
/ -------------- LOGIN
*/

// Accéder à la page login et afficher le formulaire
Route::get('/login', [AuthController::class, 'pageLogin']);

// Valider le formulaire de login et se connecter
Route::post('/login', [AuthController::class, 'loginIn']);

/*
/ -------------- SIGNUP
*/

// Accéder à la page signup et afficher le formulaire
Route::get('/signup', [AuthController::class, 'pageSignup']);

// Valider le formulaire de signup et se connecter
Route::post('/signup', [AuthController::class, 'signInUp']);

/*
/ -------------- SIGNOUT
*/

Route::post('/signout', [AuthController::class, 'signout']);

/*
/ -------------- TOP
*/

Route::get('/top', [TopController::class, 'listTop']);