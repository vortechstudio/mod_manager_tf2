<?php

declare(strict_types=1);

namespace App\Helpers;
use File;



class Translation
{
    protected $filePath;
    protected $translations = [];

    public function __construct($filePath)
    {
        $this->filePath = $filePath;

        // Vérifier si le fichier existe avant de procéder
        if (File::exists($this->filePath)) {
            $this->loadTranslations();
        } else {
            throw new \Exception("Le fichier de traduction n'existe pas : " . $this->filePath);
        }
    }

    /**
     * Récupérer toutes les traductions sous forme de tableau associatif
     */
    public function getAllTranslations()
    {
        return $this->translations;
    }

    /**
     * Récupérer une traduction spécifique pour une clé et une langue donnée
     */
    public function getTranslation($key, $language = 'en')
    {
        return $this->translations[$language][$key] ?? null;
    }

    /**
     * Charger toutes les traductions depuis le fichier strings.lua
     */
    protected function loadTranslations()
    {
        // Lire le contenu du fichier strings.lua
        $content = File::get($this->filePath);

        // Correspondance des sections de langues (ex. "en = {...}", "fr = {...}")
        if (preg_match_all("/([a-z]{2})\s*=\s*\{([^}]+)\}/s", $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $language = $match[1];  // Par exemple "en", "fr", etc.
                $translationContent = $match[2];  // Contenu des traductions pour cette langue

                // Extraire les paires clé-valeur à l'intérieur des blocs de langues
                $this->translations[$language] = $this->parseTranslationBlock($translationContent);
            }
        }
    }

    /**
     * Extraire les paires clé-valeur des blocs de traduction
     */
    protected function parseTranslationBlock($block)
    {
        $translations = [];

        // Trouver les paires clé-valeur dans le bloc de traduction
        if (preg_match_all("/([a-zA-Z0-9_]+)\s*=\s*'([^']+)'/", $block, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $key = $match[1];  // Clé de la traduction (par ex. "mod_name")
                $value = $match[2];  // Valeur de la traduction (par ex. "My Custom Mod")
                $translations[$key] = $value;
            }
        }

        return $translations;
    }

}
