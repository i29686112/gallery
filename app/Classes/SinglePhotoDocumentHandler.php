<?php


namespace App\Classes;


class SinglePhotoDocumentHandler extends PhotoHandler
{

    public function process()
    {

        $this->setFileExtensionName();
        return parent::process();

    }

    public function getFileId()
    {
        return ($this->message->getDocument()) ? $this->message->getDocument()->getFileId() : false;
    }

    private function setFileExtensionName()
    {
        $this->extensionName = ($this->message->getDocument()) ?
            getFileExtensionNameFromMimeType($this->message->getDocument()->getMimeType()) :
            false;

    }
}
