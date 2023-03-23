@extends('layout')

@section('title', 'thismemeexists')

@section('content')
@include('partials.header')
<div class="container">
    <div class="row justify-content-md-center pt-4">
        <div class="col-12 col-md-5 col-xl-4 p-4">
            <div class="px-4">
                <div class="img-container shadow-lg border border-5 border-secondary">
                    <img class="meme-img" id ="memeimg" src="{{ '/preview_meme/'.$template->id.'?top_text=&bottom_text='}}">
                </div>
            </div>
        </div>
        <div class="col col-md-auto col-xl-1"></div>
        <div class="col-12 col-md-6 col-xl-4 px-4">
            <div class="fs-2 mt-4">Текст мема</div>
            <form method="POST" action="{{ route("make_meme", ['id' => $template->id]) }}">
                @csrf
                <input name="top_text" placeholder="Верхний текст" class="form-control form-control-lg mt-4" type="text" id="toptext">
                <input name="bottom_text" placeholder="Нижний текст" class="form-control form-control-lg mt-4" type="text" id="bottomtext">
                <div class="row">
                    <div class="col col-md-auto mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Опубликовать</button>
                    </div>
                    <div class="col col-md-auto mt-4">
                        <a href="{{ '/preview_meme/'.$template->id.'?top_text=&bottom_text='}}" download="" id="download">
                            <button type="button" class="btn btn-secondary btn-lg">Скачать</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('partials.memesByThisTemplate')
</div>
<style>
    img{
        display: inline-block;
        width: 100%;
        height: auto;
    }
</style>
<script>
toptext.oninput = function() {
memeimg.src=memeimg.src.split("?")[0] + "?top_text=" + toptext.value + "&bottom_text=" + bottomtext.value;
download.setAttribute("href", memeimg.src);
};
bottomtext.oninput = function() {
memeimg.src=memeimg.src.split("?")[0] + "?top_text=" + toptext.value + "&bottom_text=" + bottomtext.value;
download.setAttribute("href", memeimg.src);
};
</script>
@endsection