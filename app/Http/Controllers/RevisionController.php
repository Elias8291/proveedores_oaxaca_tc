<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RevisionController extends Controller
{    public function index()
    {
        return view('revisiones.index');
    }
}
