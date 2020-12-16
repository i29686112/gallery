<?php


namespace App\Services;


use App\Classes\FileHandler;
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

    public function getByFilmId($filmId, $fields = ['file_name'])
    {
        $photos = $this->savedPhotoRepository->index($fields, ['film_id' => $filmId]);

        for ($i = 0; $i < $photos->count(); $i++)
        {

            $photos[$i]->photo_url = FileHandler::getUrl('photos', $photos[$i]->file_name);
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
                'file_name' => $fileName,
                'upload_telegram_user_id' => $uploadTelegramUserId,
                'film_id' => $film->id,
            ]
        );
    }
}
