<?php

namespace App\Livewire\Mod;

use App\Helpers\ParsingStringLua;
use File;
use Livewire\Component;

class EditingMod extends Component
{
    public $modPath = null;
    public $modData = [];

    public function mount($modPath)
    {
        if($modPath !== 'editingMod') {
            File::put($this->modPath.DIRECTORY_SEPARATOR.'version.txt', '');
            try {
                File::copyDirectory($this->modPath, public_path('temp'.DIRECTORY_SEPARATOR.'editingMod'));
            }catch (\Exception $e) {
                dd($e->getMessage());
            }
        }
        $this->modPath = public_path('temp'.DIRECTORY_SEPARATOR.'editingMod');
        $this->modData = $this->parseModLua($this->modPath . '/mod.lua');
    }
    public function render()
    {
        return view('livewire.mod.editing-mod', ['mod' => $this->modData, 'modPath' => $this->modPath]);
    }

    private function parseModLua(string $filePath)
    {
        if (!File::exists($filePath)) {
            flash()->addError('Le fichier mod.lua n\'existe pas.');
        }

        $luaContent = File::get($filePath);
        $modData = [];
        // Extraire le nom
        if (preg_match("/name\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $translation = (new ParsingStringLua($this->modPath.DIRECTORY_SEPARATOR.'strings.lua', 'fr'))->getTranslation($matches[1]);
            $modData['name'] = $translation;
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        // Extraire la description
        if (preg_match("/description\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $modData['description'] = $matches[1];
        }else {
            session()->flash('message', 'Impossible de trouver la description dans mod.lua.');
        }

        // Extraire les auteurs
        if (preg_match("/authors\s*=\s*\[([^\]]+)\]/s", $luaContent, $matches)) {
            $authorsJson = $matches[1];  // Contenu JSON à décoder

            // Décoder le JSON en PHP
            $authorsJson = str_replace(["\n", "\t", "{", "}"], '', $authorsJson);  // Nettoyer le format JSON
            $authorsArray = json_decode('[' . trim($authorsJson) . ']', true);  // Convertir en tableau associatif

            $modData['authors'] = $authorsArray;
        }else {
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

        if (preg_match("/severityAdd\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $modData['severityAdd'] = $matches[1];
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        if (preg_match("/severityRemove\s*=\s*_\('([^']+)'\)/", $luaContent, $matches)) {
            $modData['severityAdd'] = $matches[1];
        }else {
            session()->flash('message', 'Impossible de trouver le nom dans mod.lua.');
        }

        return $modData;
    }

    /**
     * Parser les auteurs du mod à partir de la chaîne capturée
     */
    private function parseAuthors($authorsString)
    {
        $authors = [];
        // Découper et formater chaque auteur, ici on suppose un format type { {name='John', role='CREATOR'}, ... }
        preg_match_all("/name\s*=\s*'([^']+)'/", $authorsString, $authorMatches);
        foreach ($authorMatches[1] as $author) {
            $authors[] = ['name' => $author, 'role' => 'CREATOR'];
        }

        return $authors;
    }

    /**
     * Parser les tags du mod
     */
    private function parseTags($tagsString)
    {
        // Supprimer les espaces et les quotes puis découper en tableau
        $tags = array_map('trim', explode(',', str_replace("'", '', $tagsString)));
        return $tags;
    }
}
