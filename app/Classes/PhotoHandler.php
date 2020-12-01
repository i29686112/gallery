<?php


namespace App\Classes;


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
    protected $extensionName;

    /**
     * PhotoHandler constructor.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
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

    public function process()
    {
        $caption = $this->getCaption();

        if ( ! $caption)
        {
            // 一次傳多張圖片原始檔時，會抓不到caption然後就出錯，這邊先紀錄下來
            log::error('get caption of message filed with input:' . json_encode($this->message->getRawData()));
            return false;
        }
        $fileId = $this->getFileId();
        $filePath = $this->getFilePathByFileId($fileId);
        $file = $this->getFileByFilePath($filePath);

        $savedFileName = $this->savePhotoFileAndGetSavedFileName($file, $filePath);

        if ($savedFileName !== false)
        {
            $this->responseText = SAVE_PHOTO_SUCCESS_MESSAGE . $caption;
        }

        return false;

    }

    public function getResponseText()
    {
        return $this->responseText;
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

        $fileExtensionName = ($this->extensionName) ? $this->extensionName : '';
        $photoName = getRandomFileName($fileExtensionName);

        try
        {
            $savePhotoResult = file_put_contents(storage_path('app/public/photos/' . $photoName),
                $file,
                LOCK_EX);

            if ($savePhotoResult === false)
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


}
