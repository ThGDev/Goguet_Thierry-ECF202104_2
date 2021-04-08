<x-layout>
  <x-slot name="title">
    Nouvelle critique de {{ $anime->title }}
  </x-slot>

  <article class="pagereview">
    <header class="pagereview--header">
      <h1>Nouvelle Critique de {{ $anime->title }}</h1>
    </header>
    <div class="pagereview--form">
      <form action="/anime/{{ $anime->id }}/record_review" method="POST">
      @csrf
        <input type="hidden" id="animeID" name="animeID" value="{{ $anime->id }}">
        <label for="rating">Donnez une note : </label>
        <select id="rating" name="rating">
          <!-- Pour générer un sélect de zéro à dix -->
          @foreach(['0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'] as $key => $value)
              <option value="{{ $key }}">{{ $value }}</option>
          @endforeach
        </select>
        
        <label for="comment">Laissez votre avis : </label>
        <textarea name="comment" id="comment"></textarea>
        <button class="cta">Ajouter ma critique</button>
      </form>
    </div>
  </article>
</x-layout>
