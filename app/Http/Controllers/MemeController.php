<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Meme;
use App\Actions\MemeGeneratorAction;
use Image;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{
    public function previewMeme($id, Request $request, MemeGeneratorAction $memeGeneratorAction)
    {
        $topText = $request->input('top_text');
        $bottomText = $request->input('bottom_text');
        
        $meme = $memeGeneratorAction($id,$topText,$bottomText);
        header('Content-Type: image/png');
		echo Image::make($meme)->encode('png');
	
		imagedestroy($meme);
    }

    public function makeMeme($id, Request $request,MemeGeneratorAction $memeGeneratorAction)
    {
        $topText = $request->input('top_text');
        $bottomText = $request->input('bottom_text');

        $meme = $memeGeneratorAction($id,$topText,$bottomText);

        $filenameToStore = uniqid().'.png';
        $filenameToStoreThumbnail = uniqid().'.png';
        $imagePath = public_path('storage/memes/'.$filenameToStore);
        $thumbnailPath = public_path('storage/memes_thumbnail/'.$filenameToStoreThumbnail);

        $meme->save($imagePath);

        $meme->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $meme->save($thumbnailPath);

        $save = new Meme;
        if (auth("web")->check()){
            $save->user_id = auth("web")->user()->id;
        }
        $save->image_path = $filenameToStore;
        $save->thumbnail_path = $filenameToStoreThumbnail;
        $save->template_id = $id;
        $save->save();
        return redirect()->route('meme', ['id' => $save->id]);
    }

    public function showUserMemes()
    {
        $user_id = auth("web")->user()->id;

        $memes = Meme::where('user_id', $user_id)->get()->sortBy('id')->reverse();
        return view('memes.user')->with('memes', $memes);
    }

    public function showMemePage($id)
    {
        $meme = Meme::where('id', $id)->get()->first();
        $templateId = $meme->template_id;
        $memesByThisTemplate = Meme::where('template_id', $templateId)->paginate(10);
        return view("memes.view")->with('meme', $meme)->with('memesByThisTemplate',$memesByThisTemplate);
    }
}
