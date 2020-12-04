<?php

namespace App\Classes;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileHandler
{


    public static function put($folderName, $fileName, $file)
    {

        $saveResult = false;
        try
        {
            if (env('APP_ENV') === 'production')
            {
                // local storage folder
                $saveResult = file_put_contents(storage_path('app/public/' . $folderName . '/' . $fileName),
                    $file,
                    LOCK_EX);
            } else
            {
                //s3
                $saveResult = Storage::disk('s3')->put($fileName . '/' . $fileName, $file);
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
