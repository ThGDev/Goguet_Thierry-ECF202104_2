<x-layout>
  <x-slot name="title">
    {{ $anime->title }}
  </x-slot>

  <article class="anime">
    <header class="anime--header">
      <div>
        <img alt="jaquette de {{ $anime->title }}" src="/covers/{{ $anime->cover }}" />
      </div>
      <h1>{{ $anime->title }}</h1>
    </header>
    <p>{{ $anime->description }}</p>
    <div>
    <!-- Si le visiteur veut laisser une critique, il doit être connecté, sinon ce message d'erreur s'affiche -->
    @if($errors->first('erreurConnexion'))
      <p class="error red-error">{{$errors->first()}}</p>
      <!-- Redirection vers la page de login au bout de 5 secondes, en JS -->
      <script>
          setTimeout(function() {
              window.location.href = '/login';
          }, 5000);
      </script>
    @endif
    <!-- Si le visiteur est connecté mais a déjà laissé une critique, alors ce message d'erreur s'affiche -->
    @if($errors->first('erreur'))
      <p class="error red-error">{{$errors->first()}}</p>
    @endif
    <!-- Si le visiteur est connecté mais a déjà enregistré cet anime dans sa watchlist, alors ce message d'erreur s'affiche -->
    @if($errors->first('erreurWL'))
      <p class="error red-error">{{$errors->first()}}</p>
    @endif
      <div class="actions">
        <div>
          <a class="cta" href="/anime/{{ $anime->id }}/add_review">Écrire une critique</a>
        </div>
        <form action="/anime/{{ $anime->id }}/add_to_watch_list" method="GET">
        @csrf
          <button class="cta">Ajouter à ma watchlist</button>
        </form>
      </div>
    </div>
  </article>
  <!-- Listing des Reviews -->
  <article class="anime review">
    <!-- s'il y a une critique, alors on donne la note moyenne -->
    @if(!$critiques->isEmpty())
      <h3>{{ $anime->title }} a obtenu la note moyenne de : <span class="moyenne">{{ $moyenne }}</span></h3>
    @endif
    <!-- sinon on laisse vide -->
    <header class="anime--header">
      <h1>Critiques :</h1>
    </header>
    <div>
      <!-- On vérifie s'il y a des critiques -->
      @if(!$critiques->isEmpty())
        <!-- si oui, on les liste -->
        @foreach ($critiques as $critique)
          <div class="critique">
            <p><strong>{{ $critique->username }}</strong> a donné la note de <span class="rating-note"><strong>{{ $critique->rating }}</strong>/10</span></p>
            <p class="critique-comment">{{ $critique->comment }}</p>
          </div>
        @endforeach
      @else
        <!-- si non, on affiche ce message -->
        <p>Il n'y a aucune critique pour le moment !</p>
      @endif
    </div>
  </article>
</x-layout>