<?php


namespace App\Services;


use App\Classes\FileHandler;
use App\Repositories\SavedPhotoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        for ($i = 0; $i < $photos->count(); $i++) {

            $photos[$i]->photo_url = FileHandler::getUrl('photos', $photos[$i]->file_name);
        }

        return $photos;
    }

    public function getById($photoId, $fields = ['file_name'])
    {
        return $this->savedPhotoRepository->index($fields, ['id' => $photoId]);
    }

    public function create($fileName, $uploadTelegramUserId, $film)
    {
        if (!$fileName) {
            return false;
        }

        return $this->savedPhotoRepository->create([
                'file_name'               => $fileName,
                'upload_telegram_user_id' => $uploadTelegramUserId,
                'film_id'                 => $film->id,
            ]
        );
    }

    public function deleteByIdArray($photoId)
    {

        $deletedId = [];

        if (is_numeric($photoId)) {
            $photoId = [$photoId];
        }

        if (is_array($photoId) && count($photoId) === 0) {
            return [];
        }


        try {
            $photos = $this->getById($photoId, $fields = ['id', 'file_name']);


            foreach ($photos as $photo) {

                DB::beginTransaction();

                if ($this->savedPhotoRepository->delete($photo->id) === false) {
                    throw new \Exception('Delete photo DB ROW failed with id:' . $photo->id);
                }

                if (FileHandler::delete('photos', $photo->file_name) === false) {
                    throw new \Exception('Delete photo FILE failed with id:' . $photo->id);
                }

                $deletedId[] = $photo->id;
                DB::commit();
            }

        } catch (\Exception $exception) {
            log::error(exceptionToString($exception));
            DB::rollback();
        }

        return $deletedId;

    }
}
