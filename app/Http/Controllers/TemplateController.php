<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewTemplateForm;
use App\Models\Template;
use App\Models\User;
use App\Models\Meme;
use Illuminate\Support\Facades\Storage;
use Image;

class TemplateController extends Controller
{
    public function addTemplate(NewTemplateForm $request)
    {    
        $data = $request->validated();
        $template = $request->file('template');
        $extension = $template->extension();

        $filenameToStore = uniqid().'.'.$extension;
        $filenameToStoreThumbnail = uniqid().'.'.$extension;
        
        Storage::put('public/templates/'. $filenameToStore, fopen($template, 'r+'));
        Storage::put('public/templates_thumbnail/'. $filenameToStoreThumbnail, fopen($template, 'r+'));

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

        $templates = Template::where('user_id', $user_id)->get()->sortBy('id')->reverse();
        return view('templates.user')->with('templates', $templates);
    }

    public function showTemplates()
    {
        $templates = Template::orderBy('id', 'desc')
        ->paginate(10);
        return view('index')->with('templates', $templates);
    }

    public function showTemplatePage($id){
        $template = Template::where('id', $id)->get()->first();
        if (is_null($template)){
            abort(404, "Шаблон не найден :(");
        }
        $templateId = $template->id;
        $memesByThisTemplate = Meme::where('template_id', $templateId)->paginate(10);
        return view("templates.view")->with('template', $template)->with('memesByThisTemplate',$memesByThisTemplate);;
    }


    public function showAddTemplateForm()
    {
        return view("templates.new");
    }
}
