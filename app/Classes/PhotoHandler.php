<?php


namespace App\Classes;


use App\Services\FilmService;
use App\Services\SavedPhotoService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Message;
use Redis;

class PhotoHandler
{

    /**
     * @var Message
     */
    protected $message;
    /**
     * @var \Longman\TelegramBot\Entities\PhotoSize[]
     */
    protected $photos;

    protected $responseText = SAVE_PHOTO_FAILED_MESSAGE;
    protected $extensionName = 'jpg';
    protected $filmService;
    protected $savedPhotoService;

    /**
     * PhotoHandler constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->filmService = new FilmService();
        $this->savedPhotoService = new SavedPhotoService();
    }

    /** main entrance */
    public function process()
    {
        $caption = $this->getCaption();

        if ( ! $caption)
        {
            log::error('get caption of message filed with input:' . json_encode($this->message->getRawData()));
            return false;
        }

        $fileId = $this->getFileId();
        $filePath = $this->getFilePathByFileId($fileId);
        $file = $this->getFileByFilePath($filePath);

        $film = $this->filmService->getFilmFromCaption($caption);

        if ( ! $film)
        {


            $this->responseText = UNKNOWN_FILM_MESSAGE;
            return false;
        }

        $savedFileName = $this->savePhotoFileAndGetSavedFileName($file, $filePath);

        $savedPhoto = $this->savedPhotoService->create($savedFileName, $this->message->getChat()->getId(), $film);

        if ($savedPhoto !== false)
        {

            $this->responseText = SAVE_PHOTO_SUCCESS_MESSAGE . $film->name;
        }

        return false;

    }

    protected function getCaption()
    {
        $caption = $this->message->getCaption();
        $mediaGroupId = $this->message->getProperty('media_group_id');


        if ( ! $caption && $mediaGroupId)
        {
            // 如果是一個群組群組的其他張照片，只有第一張照片會有caption，其他張的去redis裡面拿
            $caption = $this->getCaptionByMediaGroupId($mediaGroupId);
        }

        if ($caption && $mediaGroupId)
        {
            // 如果是一個群組群組的其他張照片，只有第一張照片會有caption，所以要先把第一張的caption存redis給其他張使用
            $this->saveCaptionByMediaGroupId($mediaGroupId, $caption);
        }

        return $caption;
    }

    public function getResponseText()
    {
        return $this->responseText;
    }

    protected function saveCaptionByMediaGroupId($mediaGroupId, $caption)
    {
        /** @var Redis $redis */
        $redis = resolve('Redis');

        try
        {
            // only set when the key is not exist, and it will auto deleted after 5 min
            if ($redis->set($mediaGroupId, $caption,
                ['NX', 'EX' => 5 * 60]))
            {
                return true;
            }
        } catch (Exception $e)
        {
            log::error(exceptionToString($e));

        }

        return false;
    }

    protected function getCaptionByMediaGroupId($mediaGroupId)
    {
        if ($mediaGroupId)
        {
            /** @var Redis $redis */
            $redis = resolve('Redis');

            try
            {
                return $redis->get($mediaGroupId);

            } catch (Exception $e)
            {
                log::error(exceptionToString($e));

            }
            return false;
        }

        return $this->message->getCaption();
    }


    protected function getFileId()
    {
        if ( ! $this->photos)
        {
            $this->photos = $this->message->getPhoto();
        }

        if (is_array($this->photos) && count($this->photos) > 0)
        {

            //get last file id, we want biggest photo
            return $this->photos[count($this->photos) - 1]->getFileId();
        }

        return false;
    }

    protected function getFilePathByFileId(string $fileId)
    {

        if ( ! $fileId)
        {
            return false;
        }

        try
        {
            /** @var Client $http */
            $http = resolve('GuzzleHttp\Client');
            $response = $http->get(env('TELEGRAM_BOT_API_URL') . 'bot' . env('TELEGRAM_BOT_API_KEY') . '/getFile?file_id=' . $fileId);
            $contents = json_decode($response->getBody()->getContents());
            return (isset($contents->result->file_path) && $contents->result->file_path !== '') ? $contents->result->file_path : false;

        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;

    }

    protected function getFileByFilePath(string $filePath)
    {
        if ( ! $filePath)
        {
            return false;
        }

        try
        {
            /** @var Client $http */
            $http = resolve('GuzzleHttp\Client');

            $fileUrl = $this->getFileUrl($filePath);
            $response = $http->request('get', $fileUrl);

            if ($response->getStatusCode() === 200 && $response->getBody()->getSize() > 0)
            {
                return $response->getBody()->getContents();
            }


        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;

    }

    /**
     * @param $file
     * @param $filePath
     * @return false|string
     */
    protected function savePhotoFileAndGetSavedFileName($file, $filePath)
    {

        if ($file === false)
        {
            return false;
        }


        try
        {

            $mimeType = $this->getMimeTypeFromBinString($file);

            $photoName = getRandomFileName(getFileExtensionNameFromMimeType($mimeType));;

            if (FileHandler::put('photos', $photoName, $file) === false)
            {
                //save fail
                throw new \Exception($this->getFileUrl($filePath));

            }

            return $photoName;

        } catch (Exception $e)
        {
            log::error('save photo to server failed with file url (' . $e->getMessage() . ')');
        }

        return false;


    }

    /**
     * @param string $filePath
     * @return string
     */
    protected function getFileUrl(string $filePath): string
    {
        return env('TELEGRAM_BOT_API_URL') . 'file/bot' . env('TELEGRAM_BOT_API_KEY') . '/' . $filePath;
    }


    /**
     * @param $file
     * @return false|string
     */
    protected function getMimeTypeFromBinString($file)
    {
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $file);
        rewind($stream);

        return mime_content_type($stream);
    }


}
