<?php

namespace App\Livewire\Mod;

use App\Helpers\ParsingStringLua;
use App\Helpers\Translation;
use File;
use Livewire\Component;

class EditingModGeneral extends Component
{
    public $modPath = '';  // Chemin du mod en cours d'édition
    public $modData = [];  // Données du mod (nom, description, auteurs, etc.)
    public $tags = '';     // Liste des tags (affiché sous forme de texte)
    public $mdlCount = 0;         // Nombre de fichiers .mdl
    public $totalFiles = 0;       // Nombre total de fichiers
    public $totalSize = 0;        // Taille totale du dossier du mod (en octets)
    public $imageTgaExists = false;        // Présence de image_00.tga
    public $workshopPreviewExists = false; // Présence de workshop_preview.jpg
    public $modioPreviewExists = false;    // Présence de modio_preview.jpg

    public function mount($modPath)
    {
        $this->modPath = $modPath;

        if (!File::exists($modPath . '/mod.lua')) {
            session()->flash('message', 'Le fichier mod.lua est introuvable.');
            return;
        }

        // Charger les informations depuis mod.lua
        $this->modData = $this->parseModLua($modPath . '/mod.lua');

        if (empty($this->modData)) {
            session()->flash('message', 'Aucune donnée trouvée dans le fichier mod.lua.');
        }

        // Convertir les tags en chaîne de texte pour l'affichage dans un champ input
        $this->tags = implode(',', $this->modData['tags'] ?? []);

        $this->calculateStatistics();
        $this->checkFiles();
    }

    private function parseModLua(string $filePath)
    {
        if (!File::exists($filePath)) {
            return [];
        }

        $luaContent = File::get($filePath);
        $modData = [];

        // Extraire le nom
        if (preg_match("/name\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $translation = (new ParsingStringLua(filePath: $this->modPath.DIRECTORY_SEPARATOR.'strings.lua', language: 'fr'))->getTranslation($matches[1]);
            $modData['name'] = $translation;
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        // Extraire la description
        if (preg_match("/description\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $translation = (new ParsingStringLua(filePath: $this->modPath.DIRECTORY_SEPARATOR.'strings.lua', language:'fr'))->getTranslation($matches[1]);
            $modData['description'] = $translation;
        }else {
            flash()->addError('Impossible de trouver la description dans mod.lua.');
        }

        if (preg_match("/authors\s*=\s*\[([^\]]+)\]/s", $luaContent, $matches)) {
            $authorsLua = $matches[1];

            // Initialisation du tableau des auteurs
            $authorsArray = [];

            // Extraire chaque bloc d'auteur (nom et rôle)
            if (preg_match_all("/\"name\":\s*\"([^\"]+)\",\s*\"role\":\s*\"([^\"]+)\"/", $authorsLua, $authorMatches, PREG_SET_ORDER)) {
                foreach ($authorMatches as $authorMatch) {
                    $authorsArray[] = [
                        'name' => $authorMatch[1],
                        'role' => $authorMatch[2],
                    ];
                }
            }

            // Stocker les auteurs extraits dans modData
            $modData['authors'] = $authorsArray;
        } else {
            session()->flash('message', 'Impossible de trouver les auteurs dans mod.lua.');
        }

        // Extraire les tags
        if (preg_match("/tags\s*=\s*\[([^\]]+)\]/", $luaContent, $matches)) {
            $tagsString = $matches[1];
            // Transformer la chaîne en tableau en séparant par des virgules et en supprimant les espaces/guillemets
            $modData['tags'] = array_map('trim', explode(',', str_replace('"', '', $tagsString)));
        }else {
            session()->flash('message', 'Impossible de trouver les tags dans mod.lua.');
        }

        if (preg_match("/severityAdd\s*=\s*([A-Z]+)/", $luaContent, $matches)) {
            $modData['severityAdd'] = $matches[1];
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        if (preg_match("/severityRemove\s*=\s*([A-Z]+)/", $luaContent, $matches)) {
            $modData['severityRemove'] = $matches[1];
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        return $modData;
    }

    /**
     * Ajouter un auteur au mod.
     */
    public function addAuthor()
    {
        $this->modData['authors'][] = ['name' => '', 'role' => 'CREATOR'];
    }

    /**
     * Supprimer un auteur du mod.
     */
    public function removeAuthor($index)
    {
        unset($this->modData['authors'][$index]);
        $this->modData['authors'] = array_values($this->modData['authors']);  // Réindexer
    }

    /**
     * Sauvegarder les informations générales.
     */
    public function saveGeneralInfo()
    {
        // Charger les données existantes de mod.lua
        $currentModData = $this->parseModLua($this->modPath . '/mod.lua');

        // Charger les données existantes de strings.lua
        $stringsFilePath = $this->modPath . '/strings.lua';
        $translations = (new Translation(filePath: $stringsFilePath))->getAllTranslations();

        // Initialiser le contenu à sauvegarder
        $modLuaContent = "function data()\n    return {\n";
        $modLuaContent .= "        info = {\n";

        // Vérifier et sauvegarder le nom du mod en utilisant une clé de traduction
        if ($this->modData['name'] !== $currentModData['name']) {
            $translations['mod_name'] = $this->modData['name'];
        }
        $modLuaContent .= "            name = _('mod_name'),\n";

        // Vérifier et sauvegarder la description du mod en utilisant une clé de traduction
        if ($this->modData['description'] !== $currentModData['description']) {
            $translations['mod_description'] = $this->modData['description'];
        }
        $modLuaContent .= "            description = _('mod_description'),\n";

        // Vérifier et sauvegarder les auteurs (si modifiés)
        $modLuaContent .= "            authors = {\n";
        foreach ($this->modData['authors'] as $author) {
            $modLuaContent .= "                { name = '" . $author['name'] . "', role = '" . $author['role'] . "' },\n";
        }
        $modLuaContent .= "            },\n";

        // Vérifier et sauvegarder les tags
        $modLuaContent .= "            tags = {";
        foreach (array_map('trim', explode(',', $this->tags)) as $tag) {
            $modLuaContent .= "'$tag', ";
        }
        $modLuaContent .= "},\n";

        // Sauvegarder severityAdd et severityRemove
        $modLuaContent .= "            severityAdd = " . $this->modData['severityAdd'] . ",\n";
        $modLuaContent .= "            severityRemove = " . $this->modData['severityRemove'] . ",\n";

        // Ajouter la version mineure
        $modLuaContent .= "            minorVersion = 1,\n";
        $modLuaContent .= "            visible = true,\n";

        // Fermer la section info
        $modLuaContent .= "        }\n    }\nend\n";

        // Sauvegarder dans le fichier mod.lua
        File::put($this->modPath . '/mod.lua', $modLuaContent);

        // Sauvegarder les traductions dans strings.lua
        $this->saveTranslations($translations);

        flash()->addSuccess('Informations générales sauvegardées avec succès.');
    }

    /**
 * Fonction pour sauvegarder les traductions dans strings.lua
 */
    private function saveTranslations($translations)
    {
        $translationsContent = "return {\n";
        foreach ($translations as $lang => $trans) {
            $translationsContent .= "    $lang = {\n";
            foreach ($trans as $key => $value) {
                $translationsContent .= "        $key = '" . addslashes($value) . "',\n";
            }
            $translationsContent .= "    },\n";
        }
        $translationsContent .= "};";

        // Sauvegarder dans le fichier strings.lua
        File::put($this->modPath . '/strings.lua', $translationsContent);
    }


    public function render()
    {
        //dd($this->modData);
        return view('livewire.mod.editing-mod-general');
    }

    private function calculateStatistics()
    {
        $modelsPath = $this->modPath . '/res/models';
        if (File::exists($modelsPath)) {
            $mdlFiles = File::files($modelsPath);
            $this->mdlCount = count(array_filter($mdlFiles, function ($file) {
                return $file->getExtension() === 'mdl';
            }));
        }

        $allFiles = File::allFiles($this->modPath);
        $this->totalFiles = count($allFiles);

        // Calculer la taille totale en octets
        foreach ($allFiles as $file) {
            $this->totalSize += $file->getSize();
        }
    }



    /**
     * Creates a workshop preview image by converting an existing TGA image to JPG format.//+
     *
     * This function checks for the existence of 'image_00.tga' in the mod path,//+
     * converts it to 'workshop_preview.jpg' using the ImageMagick 'convert' command,//+
     * and provides feedback on the success or failure of the operation.//+
     *
     * @return void
     **/
    public function createWorkshopPreview()
    {
        $inputFile = $this->modPath .DIRECTORY_SEPARATOR. 'image_00.tga';
        $outputFile = $this->modPath . DIRECTORY_SEPARATOR. 'workshop_preview.jpg';

        if (File::exists($inputFile)) {
            $command = "magick convert $inputFile $outputFile";
            exec($command);

            // Vérifier si la conversion a réussi
            if (File::exists($outputFile)) {
                flash()->addSuccess("Image créée avec succès.");
                $this->workshopPreviewExists = true;
            } else {
                flash()->addError("Erreur lors de la création de l'image.");
            }
        } else {
            flash()->addError("Image introuvable.");
        }
    }

    public function createModIoPreview()
    {
        $inputFile = $this->modPath . DIRECTORY_SEPARATOR. 'image_00.tga';
        $outputFile = $this->modPath . DIRECTORY_SEPARATOR.'modio_preview.jpg';

        if (File::exists($inputFile)) {
            $command = "magick convert $inputFile $outputFile";
            exec($command);

            // Vérifier si la conversion a réussi
            if (File::exists($outputFile)) {
                flash()->addSuccess("Image créée avec succès.");
                $this->modioPreviewExists = true;
            } else {
                flash()->addError("Erreur lors de la création de l'image.");
            }
        } else {
            flash()->addError("Image introuvable.");
        }
    }

    private function checkFiles()
    {
        // Vérifier la présence de image_00.tga
        $this->imageTgaExists = File::exists($this->modPath . '/image_00.tga');

        // Vérifier la présence de workshop_preview.jpg
        $this->workshopPreviewExists = File::exists($this->modPath . '/workshop_preview.jpg');

        // Vérifier la présence de modio_preview.jpg
        $this->modioPreviewExists = File::exists($this->modPath . '/modio_preview.jpg');
    }
}
