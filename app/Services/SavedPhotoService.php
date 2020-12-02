<?php


namespace App\Services;


use App\Repositories\SavedPhotoRepository;

class SavedPhotoService
{
    private $savedPhotoRepository;

    /**
     * SavedPhotoService constructor.
     */
    public function __construct()
    {
        $this->savedPhotoRepository = new SavedPhotoRepository();
    }

    public function getByFilmId($filmId)
    {
        $photos = $this->savedPhotoRepository->index(['file_path'], ['film_id' => $filmId]);

        for ($i = 0; $i < $photos->count(); $i++)
        {

            $photos[$i]->photo_url = '/storage/photos/' . $photos[$i]->file_path;
        }

        return $photos;
    }

    public function create($fileName, $uploadTelegramUserId, $film)
    {
        if ( ! $fileName)
        {
            return false;
        }

        return $this->savedPhotoRepository->create([
                'file_path' => $fileName,
                'upload_telegram_user_id' => $uploadTelegramUserId,
                'film_id' => $film->id,
            ]
        );
    }
}
