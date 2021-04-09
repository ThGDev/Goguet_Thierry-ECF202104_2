<x-layout>
  <x-slot name="title">
    Le top des animes des membres
  </x-slot>

  <article class="top">
    <header class="top--header">
      <h1>&#x1F44D; Le top des animes des membres</h1>
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
                    <!-- Ici on affiche "il y a actuellement X notes pour cet anime" -->
                    <div>
                      <p class="how-many-notes">Il y a actuellement 
                      @php $i = 0 @endphp
                        @foreach ($memberRatings as $memberRating)
                          @if ($memberRating->anime_id === $anime->anime_id)
                            @php $i++ @endphp
                          @endif
                        @endforeach
                        <strong>{{ $i }}</strong>
                       notes pour cet anime.</p>
                       <!-- Là on affiche les notes "XXX à donné la note de YY à NomDeLanime" -->
                      <span id="rating{{ $anime->anime_id }}"></span>
                    </div>
                </div>
            </div>
        </div>
      @endforeach
    </div>
  </article>
  <!-- Script pour l'animation du texte des ratings des tops -->
  <script>
    @foreach ($animes as $anime)
      var ratings{{ $anime->anime_id }} = new Typed('#rating{{ $anime->anime_id }}',{
        strings: [ 
          @foreach ($memberRatings as $memberRating)
            @if ($memberRating->anime_id === $anime->anime_id)
              @if ($memberRating->rating > 5)
                "&#x1F44D; @elseif ($memberRating->rating == 5)"&#x3030; @else"&#x1F44E; @endif<strong>{{ $memberRating->username }}</strong> a donné la note de <strong class='red'>{{ $memberRating->rating }}</strong> à <em>{{ $anime->title }}</em>&nbsp;", 
            @endif
          @endforeach
        ],
        typeSpeed: 20,
        backSpeed: 10,
        backDelay: 1000,
        cursorChar: '❤️',
        @php $i = 0; @endphp
        @foreach ($memberRatings as $memberRating)
          @if ($memberRating->anime_id === $anime->anime_id)
            @php $i++ @endphp
            @if ($i > 1)
              @php $looping = 'loop: true'; @endphp
            @else
              @php $looping = 'loop: false'; @endphp
            @endif
          @endif
        @endforeach
        {{ $looping }}
        });
    @endforeach

    /* Explications Emojis
        &#x1F44D; = 👍
        &#x3030; = 〰️
        &#x1F44E; = 👎
    */
  </script>
</x-layout>