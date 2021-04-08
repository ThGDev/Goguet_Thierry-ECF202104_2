<x-layout>
  <x-slot name="title">
    Le top des animes des membres
  </x-slot>

  <article class="top">
    <header class="top--header">
      <h1>Le top des animes des membres</h1>
    </header>
    <div class="top--form">
      <!-- On boucle sur les animés -->
      @foreach ($animes as $anime)
        <!-- Ici on place le numéro de classement de l'anime -->
        <h2>#{{ $rank++ }}</h2>
        <div class="top--content">
            <div class="top--rating">
                <!-- Si la note moyenne est inférieure à 10, on affiche un nombre flottant à 1 décimale -->
                @if ($anime->moyenne < 10)
                {{ number_format((float) $anime->moyenne, 1, '.', '') }}
                @else
                <!-- sinon on affiche juste 10 (ne peux pas être sup. à 10 de toute manière) -->
                {{ $anime->moyenne }}
                @endif
                <span>10</span>
            </div>
            <img alt="jaquette de {{ $anime->title }}" src="/covers/{{ $anime->cover }}" />
            <div class="top--content-anime">
                <h4>{{ $anime->title }}</h4>
                <p>{{ $anime->description }}</p>
                <div class="actions">
                    <div class="top--button">
                        <a class="cta" href="/anime/{{ $anime->anime_id }}" alt="voir la fiche" title="voir la fiche">Voir la fiche</a>
                    </div>
                    <div>
                        <ul>
                        <!-- on boucle sur les notes moyennes -->
                        @foreach ($memberRatings as $memberRating)
                            <!-- Petite condition pour afficher un icône selon la note -->
                            @if ($memberRating->anime_id === $anime->anime_id)
                                @if($memberRating->rating > 5)
                                    <li class="rate-plus">
                                @elseif ($memberRating->rating == 5)
                                    <li class="rate-bof">
                                @else
                                    <li class="rate-minor">
                                @endif
                                    <strong>{{ $memberRating->username }}</strong> a donné la note de <strong class="red">{{ $memberRating->rating }}</strong>
                                </li>
                            @endif
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
  </article>
</x-layout>