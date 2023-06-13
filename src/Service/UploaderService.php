<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploaderService
{
    private $params;
    private $slugger;

    public function __construct(ParameterBagInterface $params, SluggerInterface $slugger)
    {
        $this->params = $params;
        $this->slugger = $slugger;
    }

    public function add(UploadedFile $image, ?string $folder = '')
    {
        $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFileName);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
        $path = $this->params->get('images_directory') . $folder;

        if(!file_exists($path)){
            mkdir($path, 0777, true);
        }

        try{
            $image->move($path, $newFilename
            );
        }   catch (FileException $e){

        }

        return $newFilename;
    }

    // Pour supprimer une image dans le dossier en question 
    public function delete(string $fichier, ?string $folder = '')
    {
        // Si le fichier est différent de l'image par défaut
        if(($fichier != 'default.jpg') && ($fichier != 'default.png')){
            $path = $this->params->get('images_directory') . $folder;
            $imageASupprimer = $path . '/' . $fichier;
            if(file_exists($imageASupprimer)){
                unlink($imageASupprimer);
            }

        }


    }
}

?>