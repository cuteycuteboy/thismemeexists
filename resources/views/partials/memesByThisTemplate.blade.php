<div class="pt-5">
    <div class="fs-2 mt-5 text-center">Другие мемы по этому шаблону</div>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mt-2 px-4">
        @foreach($memesByThisTemplate as $meme)
        <div class="col px-3 py-1">
            <div class="card shadow-sm p-2">
                <div class="text-center mb-2">
                    <a href="{{ route('template', ['id' => $meme->template_id]) }}">
                        <button type="button" class="btn btn-outline-secondary mx-auto">Создать мем</button>
                    </a>
                </div>
                <a href="{{ route('meme', ['id' => $meme->id]) }}">
                <img src="{{ '/storage/memes_thumbnail/'.$meme->thumbnail_path }}">
                </a>
            </div>
            </div>
        @endforeach
    </div>
</div>