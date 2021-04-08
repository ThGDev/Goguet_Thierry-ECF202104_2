<x-layout>
  <x-slot name="title">
    Watchlist de {{ Auth::user()->username }}
  </x-slot>

  <article class="pagewatch">
    <header class="pagewatch--header">
      <h1>Watchlist de {{ Auth::user()->username }}</h1>
    </header>
    <!-- On vérifie s'il y a des critiques -->
    @if(!$animes->isEmpty())
        <!-- si oui, on les liste -->
    @foreach ($animes as $anime)
      <div class="pagewatch--content">
          <img alt="jaquette de {{ $anime->title }}" src="/covers/{{ $anime->cover }}" />
          <div class="pagewatch--content-anime">
              <h4>{{ $anime->title }}</h4>
              <p>{{ $anime->description }}</p>
              <div class="actions">
                  <div class="pagewatch--button">
                      <a class="cta" href="/anime/{{ $anime->anime_id }}" alt="voir la fiche" title="voir la fiche">Voir la fiche</a>
                      <a class="cta" href="/watchlist/delete/{{ $anime->anime_id }}" alt="supprimer de ma liste" title="supprimer de ma liste"><span class="iconify" data-icon="grommet-icons:trash" data-inline="false"></span></a>
                  </div>
              </div>
          </div>
      </div>
    @endforeach
        
    @else
        <!-- si non, on affiche ce message -->
        <p>Il n'y a aucun anime dans votre watchlist pour le moment !</p>
    @endif
    
  </article>
</x-layout>