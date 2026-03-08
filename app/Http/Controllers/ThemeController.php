<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return view('themes.index', compact('themes'));
    }

    public function store(Request $request)
    {
        Theme::create([
            'name' => $request->name,
            'color_name' => $request->color
        ]);

        return redirect('/themes');
    }

    public function destroy($id)
    {
    $theme = Theme::findOrFail($id);

    if($theme->is_default){
    return redirect()->back();
    }

    $theme->delete();

    return redirect()->back();
    }
}
