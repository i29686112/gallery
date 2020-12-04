<?php


namespace App\Repositories;


use App\Models\Film;

class FilmRepository
{
    /**
     * @var Film
     */
    private $film;

    /**
     * FilmRepository constructor.
     */
    public function __construct()
    {
        $this->film = new Film();
    }

    public function getFilmByKeyName(string $keyName)
    {
        $query = $this->film->newQuery();
        return $query->where('key_name', $keyName)->limit(1)->first();
    }

    public function index()
    {
        $query = $this->film->newQuery();
        return $query->get(['id', 'name', 'cover_image_name', 'description']);
    }
}
