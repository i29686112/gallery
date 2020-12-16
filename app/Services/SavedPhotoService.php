<?php


namespace App\Services;


use App\Classes\FileHandler;
use App\Repositories\SavedPhotoRepository;
use Illuminate\Support\Facades\DB;

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

    public function getById($photoId, $fields = ['file_name'])
    {
        return $this->savedPhotoRepository->index($fields, ['id' => $photoId], null, 1, 1)->first();
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

    public function deleteById($photoId)
    {
        if ( ! $photoId)
        {
            return false;
        }

        DB::beginTransaction();

        try
        {
            $photo = $this->getById($photoId, $fields = ['file_name']);

            if ($this->savedPhotoRepository->delete($photoId) === false)
            {
                throw new \Exception('Delete photo DB ROW failed with id:' . $photoId);
            }

            if (FileHandler::delete('photos', $photo->file_name) === false)
            {
                throw new \Exception('Delete photo FILE failed with id:' . $photoId);
            }

            DB::commit();

            return true;
        } catch (\Exception $exception)
        {
            DB::rollback();
        }

    }
}
