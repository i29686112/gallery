<?php


namespace App\Classes;

class MultiplePhotoDocumentHandler extends PhotoHandler
{
    public function process()
    {

        // 先回傳暫不支援，無法設計出合理的使用流程
        $this->responseText = NOT_SUPPORT_UNCOMPRESSED_PHOTO;

        return false;

    }


}
