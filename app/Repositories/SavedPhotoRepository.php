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

    public function delete($id)
    {

        try
        {
            return $this->savedPhoto->where('id', $id)->delete();

        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;
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

    public function index(
        $fields = ['*'],
        $conditions = [],
        $orderBy = ['updated_at' => -1],
        $page = false,
        $rowPerPage = false
    ) {

        $query = $this->savedPhoto->newQuery();

        if (isset($conditions['film_id']) && is_numeric($conditions['film_id']))
        {
            $query->where('film_id', $conditions['film_id']);
        }

        if (isset($conditions['id']) && is_numeric($conditions['id']))
        {
            $query->where('id', $conditions['id']);
        }


        if (is_array($orderBy))
        {
            foreach ($orderBy as $orderField => $sort)
            {
                $query->orderBy($orderField, ($sort === -1) ? 'desc' : 'asc');
            }
        }

        if (is_numeric($page) && is_numeric($rowPerPage))
        {
            $query->offset(($page - 1) * $rowPerPage);
            $query->limit($rowPerPage);
        }


        return $query->get($fields);
    }
}
