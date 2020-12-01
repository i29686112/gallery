<?php

namespace App\Http\Controllers;

use App\Services\FilmService;

class FilmController extends Controller
{
    //
    public function index()
    {
        $filmService = new FilmService();
        $films = $filmService->index();


    }
}
