<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function switch(Request $request)
    {
        $theme = $request->input('theme', 'light');
        session(['theme' => $theme]);
        
        return redirect()->back();
    }
}