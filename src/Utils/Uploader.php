<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    public function upload(UploadedFile $file, string $directory, string $name ="")
    {
        // vérifier que le fichier existe
        if (!$file->isFile()) {
            throw new \InvalidArgumentException('Le fichier n\'a pas été trouvé.');
        }


        // création d'un nouveau nom
        $newFileName = $name . ".jpg";
        ///"." . $file->guessExtension();
        // copie du fichier dans le répertoire de sauvegarde en le renommant
        $file->move($directory, $newFileName);

        return $newFileName;
    }
}

