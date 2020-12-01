<?php


namespace App\Repositories;


use App\Models\SavedPhoto;
use Illuminate\Support\Facades\Log;

class SavedPhotoRepository
{
    /**
     * @var SavedPhoto
     */
    private $savedPhoto;

    /**
     * SavedPhotoRepository constructor.
     */
    public function __construct()
    {
        $this->savedPhoto = new SavedPhoto();
    }

    public function create($data)
    {

        try
        {
            return $this->savedPhoto->create($data);

        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;
    }
}
