<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Image;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{
    public function previewMeme($id, Request $request){
        $topText = $request->get('top_text');
        $bottomText = $request->get('bottom_text');
        
        $template = Template::where('id', $id)->get()->first();

        $memePath = public_path('storage/templates/'.$template->image_path);
        $img = Image::make($memePath);
        

        // use callback to define details
        $img->text('fosdaffffffffo', 0, 0, function($font) {
            $font->file(base_path('storage/app/public/impact.ttf'));
            $font->size(24);
            $font->color('#FFFFFF');
            $font->valign('top');
        });

        return $img->response();
    }
    
}
