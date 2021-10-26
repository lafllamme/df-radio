<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AudioController extends Controller
{
    public function getData(Request $request)
    {
        dd($request->all());
    }
}
