<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function AddTemplate(Request $request)
    {
        dd($request);
        return "dfs";
        // return view("templates.new");
    }

    public function showAddTemplateForm()
    {
        return view("templates.new");
    }
}
