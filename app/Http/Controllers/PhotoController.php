<?php

namespace App\Http\Controllers;

use App\Services\SavedPhotoService;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class PhotoController extends Controller
{
    //
    public function index($filmId)
    {

        $savedPhotoService = new SavedPhotoService();
        $savedPhotos = $savedPhotoService->getByFilmId($filmId);

        return ResponseBuilder::success($savedPhotos);

    }

}
