<div>
    <div class="fs-2 mt-5 text-center">Другие мемы по этому шаблону</div>
    <div class="row row-cols-3 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-3 mt-4" id="masonry-container" data-masonry='{"percentPosition": true }' >
        @foreach($memesByThisTemplate as $meme)
        <div class="col px-4 py-1">
            <div class="card shadow-sm px-4">
                <div class="text-center my-2">
                <a href="{{ route('template', ['id' => $meme->template_id]) }}">
                    <button type="button" class="btn btn-outline-secondary mx-auto">Создать мем</button>
                </a>
                </div>
                <a href="{{ route('meme', ['id' => $meme->id]) }}">
                <img src="{{ Vite::asset('storage/app/public/memes_thumbnail/'.$meme->thumbnail_path) }}">
                </a>
                <div class="card-body">
                </div>
            </div>
            </div>
        @endforeach
    </div>
</div>