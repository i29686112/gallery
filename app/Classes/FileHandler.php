<?php

namespace App\Classes;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileHandler
{

    public static function delete($folderName, $fileName)
    {

        $deleteResult = false;
        try
        {
            $path = $folderName . '/' . $fileName;
            if (env('APP_ENV') === 'production')
            {
                //s3
                $deleteResult = Storage::disk('s3')->delete($path);

            } else
            {
                $path = 'public/' . $path;
                // local storage folder
                $deleteResult = Storage::delete($path);
            }

            if ($deleteResult === false)
            {
                throw new \Exception('Save file failed with path:' . $path . '/' . $fileName);
            }
        } catch (\Exception $e)
        {

            log::error('delete file error (' . $e->getMessage() . ')');
        }


        return $deleteResult;

    }


    public static function put($folderName, $fileName, $file)
    {

        $saveResult = false;
        try
        {
            $path = $folderName . '/' . $fileName;
            if (env('APP_ENV') === 'production')
            {
                //s3
                $saveResult = Storage::disk('s3')->put($path, $file, ['visibility' => 'public']);

            } else
            {

                $path = 'public/' . $path;

                // local storage folder
                $saveResult = Storage::disk('local')->put($path, $file);
            }

            if ($saveResult === false)
            {
                throw new \Exception('Save file failed with path:' . $folderName . '/' . $fileName);
            }

        } catch (\Exception $e)
        {

            log::error('save file error (' . $e->getMessage() . ')');
        }


        return $saveResult;

    }

    public static function getUrl($folderName, $fileName)
    {

        if (env('APP_ENV') === 'production')
        {
            //s3
            $url = env('AWS_S3_PUBLIC_URL') . $folderName . "/" . $fileName;
        } else
        {

            // local storage folder
            $url = env('APP_URL') . '/storage/' . $folderName . '/' . $fileName;
        }

        return $url;
    }
}
