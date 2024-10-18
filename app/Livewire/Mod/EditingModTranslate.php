<?php

namespace App\Livewire\Mod;

use App\Helpers\ParsingStringLua;
use App\Helpers\Translation;
use File;
use Http;
use Livewire\Component;
use Log;

class EditingModTranslate extends Component
{
    public $modPath;
    public $translations = [];
    public $selectedLanguage = 'en';  // Langue par défaut
    public $languages = ['en', 'fr', 'de'];  // Liste des langues disponibles
    public $customKeys = [];  // Liste des clés ajoutées dynamiquement par l'utilisateur
    public $newKey = '';  // Clé à ajouter
    public $newLanguage = '';  // Nouvelle langue à ajouter
    public $sourceLanguage = 'en';  // Langue source pour la traduction automatique

    public function mount($modPath)
    {
        $this->modPath = $modPath;

        // Charger les traductions actuelles depuis strings.lua
        $this->translations = (new Translation(filePath: $this->modPath . '/strings.lua'))->getAllTranslations();
    }

    /**
     * Ajouter une nouvelle clé de traduction
     */
    public function addNewKey()
    {
        if (trim($this->newKey) !== '' && !in_array($this->newKey, $this->customKeys)) {
            $this->customKeys[] = $this->newKey;

            foreach ($this->languages as $lang) {
                $this->translations[$lang][$this->newKey] = '';
            }

            $this->newKey = '';
        }
    }

    /**
     * Supprimer une clé de traduction
     */
    public function removeKey($key)
    {
        if (($index = array_search($key, $this->customKeys)) !== false) {
            unset($this->customKeys[$index]);
        }

        foreach ($this->languages as $lang) {
            unset($this->translations[$lang][$key]);
        }
    }

    /**
     * Ajouter une nouvelle langue
     */
    public function addLanguage()
    {
        if (trim($this->newLanguage) !== '' && !in_array($this->newLanguage, $this->languages)) {
            $this->languages[] = $this->newLanguage;

            // Ajouter la langue avec des valeurs par défaut vides pour chaque clé existante
            foreach ($this->translations as $lang => $trans) {
                $this->translations[$this->newLanguage][$lang] = '';
            }

            $this->newLanguage = '';
        }
    }

    /**
     * Supprimer une langue
     */
    public function removeLanguage($lang)
    {
        if (($index = array_search($lang, $this->languages)) !== false) {
            unset($this->languages[$index]);
            unset($this->translations[$lang]);
        }
    }

    /**
     * Traduire automatiquement les clés de la langue source vers les autres langues
     */
    public function translateAutomatically()
    {
        $sourceLang = $this->sourceLanguage;

        foreach ($this->languages as $targetLang) {
            if ($targetLang !== $sourceLang) {
                foreach ($this->translations[$sourceLang] as $key => $value) {
                    $translatedText = $this->translateText($value, $sourceLang, $targetLang);
                    $this->translations[$targetLang][$key] = $translatedText;
                }
            }
        }

        session()->flash('message', 'Traduction automatique terminée.');
    }

    /**
     * Fonction pour traduire du texte via l'API LibreTranslate
     */
    private function translateText($text, $sourceLang, $targetLang)
    {
        $response = Http::post('https://libretranslate.com/translate', [
            'q' => $text,
            'source' => $sourceLang,
            'target' => $targetLang,
            'format' => 'text',
        ]);

        return $response->json()['translatedText'] ?? $text;  // Retourne la traduction ou le texte d'origine en cas d'erreur
    }

    /**
     * Sauvegarder les traductions modifiées dans le fichier strings.lua
     */
    public function saveTranslations()
    {
        $this->validate([
            "translations.*.mod_name" => "nullable|string|max:255",
            "translations.*.mod_description" => "nullable|string",
            // Validation pour les nouvelles clés
            "translations.*.*" => "nullable|string",
        ]);

        // Sauvegarder les traductions dans le fichier strings.lua
        try {
            $this->writeTranslationsToFile();
            flash()->addSuccess('Les traductions ont été sauvegardées avec succès.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            flash()->addError($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Écrire les traductions dans le fichier strings.lua
     */
    private function writeTranslationsToFile()
    {
        $content = "return {\n";

        foreach ($this->translations as $lang => $trans) {
            $content .= "    $lang = {\n";
            foreach ($trans as $key => $value) {
                $content .= "        $key = '" . addslashes($value) . "',\n";
            }
            $content .= "    },\n";
        }

        $content .= "};";

        // Sauvegarder dans le fichier strings.lua
        File::put($this->modPath . '/strings.lua', $content);
    }

    public function render()
    {
        return view('livewire.mod.editing-mod-translate');
    }
}
