@extends('layout')

@section('title', 'Мои мемы')

@section('content')
    @include('partials.header')
    <div class="album px-4 py-5">
    <div class="container px-2">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 g-3" id="masonry-container" data-masonry='{"percentPosition": true }' >
          @foreach($memes as $meme)
          <div class="col px-3 py-1">
            <div class="card shadow p-2">
              <a href="{{ route('meme', ['id' => $meme->id]) }}">
                <img src="{{ '/storage/memes_thumbnail/'.$meme->thumbnail_path }}">
              </a>
            </div>
          </div>
          @endforeach
      </div>
      <div class="mt-4">
        <nav aria-label="Page navigation example">
          <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
              <a class="page-link" href="{{ $memes->previousPageUrl() }}">Назад</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="{{ $memes->nextPageUrl() }}">Вперед</a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
<style>
  img{
      display: inline-block;
      width: 100%;
      height: auto;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js" integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async></script>
<script>
{{-- Это код, чтобы Masonry сетка прваильно отображалась.
  Просто Masonry применяет стили, пока пикчи не прогрузились.
  Поэтому я перезагружаю сетку.
  Понимаю, что это костылль, но ладно
--}}
setTimeout(function () {
  var msnry = new Masonry('#masonry-container');
  msnry.layout();
}, 100);

setTimeout(function () {
  var msnry = new Masonry('#masonry-container');
  msnry.layout();
}, 300);

setTimeout(function () {
  var msnry = new Masonry('#masonry-container');
  msnry.layout();
}, 1000);

setTimeout(function () {
  var msnry = new Masonry('#masonry-container');
  msnry.layout();
}, 5000);
</script>
@endsection
