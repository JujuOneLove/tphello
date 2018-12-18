<?php

namespace App\Upload;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUserUpload
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(User $user)
    {

        if ($user->getPictureFile() !== null) {
            $fileName = md5(uniqid()).'.'.$user->getPictureFile()->guessExtension();
            try {
                $user->getPictureFile()->move($this->getTargetDirectory().User::DIR_UPLOAD, $fileName);
                $user->setPicture($fileName);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
                throw new \Exception('Error when upload picture');
            }
        }
    }

    public function removeFile(User $user)
    {
        if ($user->getPicture() !== null) {
            return \unlink($this->getTargetDirectory().User::DIR_UPLOAD.'/'.$user->getPicture());
        }

        return true;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}