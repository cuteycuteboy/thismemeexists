@extends('layout')

@section('title', 'thismemeexists')

@section('content')
    @include('partials.header')
    <div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3 g-3" id="masonry-container" data-masonry='{"percentPosition": true }' >
          @foreach($templates as $template)
          <div class="col px-5 py-1">
            <div class="card shadow-sm px-4">
              <div class="text-center my-2">
                <a href="{{ route('template', ['id' => $template->id]) }}">
                  <button type="button" class="btn btn-outline-secondary mx-auto">Создать мем</button>
                </a>
              </div>
              <a href="{{ route('template', ['id' => $template->id]) }}">
                <img src="{{ Vite::asset('storage/app/public/templates_thumbnail/'.$template->thumbnail_path) }}">
              </a>
              <div class="card-body">
                <p class="card-text">Тут должны быть теги, но их нет. Возможно потом реализую, но сейчас лень.</p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                  </div>
                  <small class="text-muted">9 mins</small>
                </div>
              </div>
            </div>
          </div>
          @endforeach
      </div>
    </div>
  </div>
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
