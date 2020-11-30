<?php


namespace App\Classes;


use App\Exceptions\SavePhotoToServerFailedException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\Message;
use Redis;

class PhotoHandler
{
    /**
     * @var Message
     */
    private $message;
    /**
     * @var \Longman\TelegramBot\Entities\PhotoSize[]
     */
    private $photos;


    /**
     * PhotoHandler constructor.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getCaption()
    {
        $caption = $this->message->getCaption();

        if ($caption && $mediaGroupId = $this->message->getProperty('media_group_id'))
        {

            $this->saveCaptionByMediaGroupId($mediaGroupId, $caption);

        } else
        {

            $caption = $this->getCaptionByMediaGroupId($mediaGroupId);

        }

        return $caption;
    }

    private function saveCaptionByMediaGroupId($mediaGroupId, $caption)
    {
        /** @var Redis $redis */
        $redis = resolve('Redis');

        // only set when the key is not exist, and it will auto deleted after 5 min
        if ($redis->set($mediaGroupId, $caption,
            ['NX', 'EX' => 5 * 60]))
        {
            return true;
        }

        return false;
    }

    public function getCaptionByMediaGroupId($mediaGroupId)
    {
        if ($mediaGroupId)
        {
            /** @var Redis $redis */
            $redis = resolve('Redis');

            return $redis->get($mediaGroupId);
        }

        return $this->message->getCaption();
    }


    public function getFileId()
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

        /** @var Client $http */
        $http = resolve('GuzzleHttp\Client');

        try
        {
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

        /** @var Client $http */
        $http = resolve('GuzzleHttp\Client');

        try
        {
            /** @var Client $http */
            $http = resolve('GuzzleHttp\Client');

            $fileUrl = env('TELEGRAM_BOT_API_URL') . 'file/bot' . env('TELEGRAM_BOT_API_KEY') . '/' . $filePath;
            $response = $http->request('get', $fileUrl);
            return $response;

        } catch (\Exception $e)
        {
            log::error(exceptionToString($e));
        }
        return false;

    }

    /**
     * @param $fileUrl
     * @param $response
     * @return false|string
     * @throws SavePhotoToServerFailedException
     */
    protected function savePhotoFileAndGetSavedFileName($fileUrl, $response)
    {

        if ($response->getStatusCode() === 200 && $response->getBody()->getSize() > 0)
        {

            $photoName = getRandomFileName();

            $savePhotoResult = file_put_contents(storage_path('app/public/photos/' . $photoName),
                $response->getBody()->getContents(),
                LOCK_EX);

            if ($savePhotoResult === false)
            {
                //save fail

                throw new SavePhotoToServerFailedException($fileUrl);

            }

            return $photoName;

        }
        return false;
    }


}
