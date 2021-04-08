<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function addReviewIfConnected($id)
    {
        // je vérifie que l'auteur de la critique soit bien connecté
        if (Auth::check()){
            $userID = Auth::id();
            // Je vérifie qu'il n'a pas déjà saisi une critique pour cet anime
            $critique = DB::table('reviews')
                            ->where('anime_id', '=', $id)
                            ->where('user_id', '=', $userID)
                            ->first();
            // s'il n'a pas encore écrit de critique, il est redirigé vers la page de rédaction d'une critique
            if($critique === null){
                return redirect('/anime/'.$id.'/new_review');
            } else {    // s'il a déjà écrit une critique, un message d'erreur s'affiche
                return back()->withErrors(['erreur' => 'Vous avez déjà rédigé une critique pour cet anime']);
            }
            
        }
        // si le visiteur n'est pas connecté, alors ce message d'erreur s'affiche
        return back()->withErrors(['erreurConnexion' => 'Vous devez avoir un compte et être connecté pour écrire une critique ! (vous allez être redirigé dans 5 sec.)']);
    }

    public function addToWatchlistIfConnected($id)
    {
        // je vérifie que le visiteur soit bien connecté
        if (Auth::check()){
            $userID = Auth::id();
            // Je vérifie qu'il n'a pas déjà cet anime dans sa watchlist
            $inWatchlist = DB::table('watchlists')
                            ->where('anime_id', '=', $id)
                            ->where('user_id', '=', $userID)
                            ->first();
                            
            // s'il n'a pas encore cet anime dans sa WL, il est redirigé vers la page d'enregistrement de WL
            if($inWatchlist === null){
                return redirect('insert_to_watch_list/'.$id);
            } else {    // s'il a déjà l'anime dans sa WL, un message d'erreur s'affiche
                return back()->withErrors(['erreurWL' => 'Vous avez déjà cet anime dans votre watchlist !']);
            }
            
        }
        // si le visiteur n'est pas connecté, alors ce message d'erreur s'affiche
        return back()->withErrors(['erreurConnexion' => 'Vous devez avoir un compte et être connecté pour ajouter cet anime dans une watchlist ! (vous allez être redirigé dans 5 sec.)']);
    }

    public function pageLogin()
    {
        return view('login');
    }

    public function loginIn(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
          ]);
          if (Auth::attempt($validated)) {
            return redirect()->intended('/');
          }
          return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
          ]);
    }

    public function pageSignup()
    {
        return view('signup');
    }

    public function signInUp(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
            "password_confirmation" => "required|same:password"
          ]);
          $user = new User();
          $user->username = $validated["username"];
          $user->password = Hash::make($validated["password"]);
          $user->save();
          Auth::login($user);
        
          return redirect('/');
    }

    public function signout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}