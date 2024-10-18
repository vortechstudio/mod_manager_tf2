<?php

namespace App\Livewire\Mod;

use File;
use Livewire\Component;

class EditingModConvert extends Component
{
    public $modPath;  // Chemin du mod
    public $tgaFiles = [];  // Liste des fichiers TGA
    public $selectedFiles = [];  // Fichiers sélectionnés par le moddeur

    public function mount($modPath)
    {
        $this->modPath = $modPath;
        $this->loadTgaFiles();
    }

    public function loadTgaFiles()
    {
        $this->tgaFiles = File::allFiles($this->modPath.DIRECTORY_SEPARATOR.'res'.DIRECTORY_SEPARATOR.'textures');  // Récupère tous les fichiers dans le mod

        // Convertir les objets File en chaînes de caractères (chemins de fichiers)
        $this->tgaFiles = array_map(function ($file) {
            return $file->getPathname();  // Renvoyer le chemin complet du fichier en tant que chaîne de caractères
        }, $this->tgaFiles);

        // Filtrer uniquement les fichiers .tga
        $this->tgaFiles = array_filter($this->tgaFiles, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'tga';
        });
    }

    public function convertSelectedFiles()
    {
        try {
            $filesToConvert = !empty($this->selectedFiles) ? $this->selectedFiles : $this->tgaFiles;

            foreach ($filesToConvert as $file) {
                $this->convertTgaToDds($file);
            }

            flash()->addSuccess('Conversion des fichiers sélectionnés réussie !');
        }catch(\Exception $e) {
            flash()->addError($e->getMessage());
        }
    }

    private function convertTgaToDds($filePath)
    {
        $outputPath = str_replace('.tga', '.dds', $filePath);

        // Vérifier si le fichier est un normal map en regardant son nom
        $isNormalMap = strpos(strtolower($filePath), 'normal') !== false;

        // Vérifier la transparence (canal alpha) avec ImageMagick
        $hasAlpha = shell_exec("magick identify -format '%[channels]' $filePath");

        if ($isNormalMap) {
            // Carte normale -> Compression BC5 (ATI2/DXT5nm) avec Mipmap
            $command = "magick convert $filePath -format dds -define dds:compression=bc5 -define dds:mipmaps=13 $outputPath";
        } elseif (strpos($hasAlpha, 'alpha') !== false) {
            // Image avec transparence -> Compression avec alpha (BC3/DXT5) avec Mipmap
            $command = "magick convert $filePath -format dds -define dds:compression=dxt5 -define dds:mipmaps=13 $outputPath";
        } else {
            // Image sans transparence -> Compression sans alpha (BC1/DXT1) avec Mipmap
            $command = "magick convert $filePath -format dds -define dds:compression=dxt1 -define dds:mipmaps=13 $outputPath";
        }

        exec($command);
    }

    public function render()
    {
        return view('livewire.mod.editing-mod-convert');
    }
}
