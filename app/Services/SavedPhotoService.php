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

    public function create($fileName, $uploadTelegramUserId, $film)
    {
        if ( ! $fileName)
        {
            return false;
        }
        $filePath = 'storage/photos/' . $fileName;

        return $this->savedPhotoRepository->create([
                'file_path' => $filePath,
                'upload_telegram_user_id' => $uploadTelegramUserId,
                'film_id' => $film->id,
            ]
        );
    }
}
