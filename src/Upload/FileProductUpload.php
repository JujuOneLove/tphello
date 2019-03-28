<?php

namespace App\Upload;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileProductUpload
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(Product $product)
    {

        if ($product->getPictureFile() !== null) {
            $fileName = md5(uniqid()).'.'.$product->getPictureFile()->guessExtension();
            try {
                $product->getPictureFile()->move($this->getTargetDirectory().Product::DIR_UPLOAD, $fileName);
                $product->setPicture($fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                throw new \Exception('Error when upload picture');
            }
        }
    }

    public function removeFile(Product $product)
    {
        if ($product->getPicture() !== null) {
            return \unlink($this->getTargetDirectory().Product::DIR_UPLOAD.'/'.$product->getPicture());
        }

        return true;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
