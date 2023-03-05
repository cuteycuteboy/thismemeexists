@extends('layout')

@section('title', 'thismemeexists')

@section('content')
    @include('partials.header')
<div class="">
    <div class="container">
        <div class="row justify-content-md-center pt-5">
                <div class="col-12 col-md-5 col-lg-4 p-4">
                    <div class="shadow-lg border border-5 border-secondary">
                        <div class="img-container">
                        <img class="meme-img" id ="memeimg" src="{{ '/preview_meme/'.$template->id.'?top_text=&bottom_text='}}">
                        </div>
                    </div>
                </div>
                <div class="col col-md-auto col-lg-1"></div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="fs-2 my-4">Текст мема</div>
                    <input name="toptext" placeholder="Верхний текст" class="form-control form-control-lg mb-4" type="text" id="toptext">
                    <input name="bottomtext" placeholder="Нижний текст" class="form-control form-control-lg mb-4" type="text" id="bottomtext">
                    <div class="row">
                        <div class="col col-5">
                            <button type="submit" class="btn btn-primary btn-lg">Опубликовать</button>
                        </div>
                        <div class="col col-5">
                            <a href="{{ '/preview_meme/'.$template->id.'?top_text=&bottom_text='}}" download="" id="download">
                                <button type="submit" class="btn btn-secondary btn-lg">Скачать</button>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<style>
    .meme-img{
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
