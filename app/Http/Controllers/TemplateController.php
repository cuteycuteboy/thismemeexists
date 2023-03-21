<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewTemplateRequest;
use App\Models\Template;
use App\Models\User;
use App\Models\Meme;
use Illuminate\Support\Facades\Storage;
use Image;

class TemplateController extends Controller
{
    public function addTemplate(NewTemplateRequest $request)
    {    
        $data = $request->validated();
        $template = $request->file('template');
        $extension = $template->extension();

        $filenameToStore = uniqid().'.'.$extension;
        $filenameToStoreThumbnail = uniqid().'.'.$extension;
        
        Storage::put('public/templates/'. $filenameToStore, fopen($template, 'r+'));
        Storage::put('public/templates_thumbnail/'. $filenameToStoreThumbnail, fopen($template, 'r+'));

        $imagePath = public_path('storage/templates/'.$filenameToStore);
        if(getimagesize($imagePath)[0] > 1024){
            $templateImage = Image::make($imagePath)->resize(1024, null, function($constraint)
            {
                $constraint->aspectRatio();
            });
            $templateImage->save($imagePath);
        }
        $thumbnailPath = public_path('storage/templates_thumbnail/'.$filenameToStoreThumbnail);
        $templateTumbnail = Image::make($thumbnailPath)->resize(300, null, function($constraint)
        {
            $constraint->aspectRatio();
        });
        $templateTumbnail->save($thumbnailPath);

        $save = new Template;
        if (auth("web")->check()){
            $save->user_id = auth("web")->user()->id;
        }
        $save->image_path = $filenameToStore;
        $save->thumbnail_path = $filenameToStoreThumbnail;
        $save->save();

        return redirect()->route('home');
        
    }

    public function showUserTemplates(){
        $user_id = auth("web")->user()->id;

        $templates = Template::where('user_id', $user_id)->orderBy('id', 'desc')->simplePaginate(12);
        return view('templates.user')->with('templates', $templates);
    }

    public function showTemplates()
    {
        $templates = Template::orderBy('id', 'desc')->simplePaginate(12);
        return view('index')->with('templates', $templates);
    }

    public function showTemplatePage($id){
        $template = Template::where('id', $id)->get()->first();
        if (is_null($template)){
            abort(404, "Шаблон не найден :(");
        }
        $templateId = $template->id;
        $memesByThisTemplate = Meme::where('template_id', $templateId)->orderBy('id', 'desc')->simplePaginate(12);
        return view("templates.view")->with('template', $template)->with('memesByThisTemplate',$memesByThisTemplate);;
    }


    public function showAddTemplateForm()
    {
        return view("templates.new");
    }
}
