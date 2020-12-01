<?php


namespace App\Services;


use App\Repositories\FilmRepository;

class FilmService
{


    private $filmRepository;

    /**
     * FilmService constructor.
     */
    public function __construct()
    {
        $this->filmRepository = new FilmRepository();
    }


    public function index()
    {
        return $this->filmRepository->index();
    }

    public function getFilmFromCaption($caption)
    {
        $keyName = $this->getKeyNameFromCaption($caption);
        return $this->filmRepository->getFilmByKeyName($keyName);
    }

    public function getKeyNameFromCaption($caption)
    {
        // only keep alphanumeric, other replace with empty string
        return preg_replace('/[\W\s]*/m', '', strtolower($caption));
    }

}
