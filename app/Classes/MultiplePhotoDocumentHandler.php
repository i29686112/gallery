<?php


namespace App\Classes;


/**
 * @note 尚未實作完成，不會被使用的class，一次傳多個圖片檔案，無法直覺地取得caption
 */
class MultiplePhotoDocumentHandler extends PhotoHandler
{
    public function process()
    {

        $this->responseText = NOT_SUPPORT_MULTIPLE_PHOTO_FILES;

        return false;

    }


}
