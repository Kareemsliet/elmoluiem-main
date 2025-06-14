<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display the main panel page.
     */
    public function index()
    {
        return view("panel.index");
    }

}
