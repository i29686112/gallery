<?php

namespace App\Http\Controllers;

use App\Services\FilmService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class FilmController extends Controller
{
    //
    public function index()
    {
        $filmService = new FilmService();
        $films = $filmService->index();

        return ResponseBuilder::success($films);

    }
}
