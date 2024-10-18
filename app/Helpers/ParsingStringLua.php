<?php

declare(strict_types=1);

namespace App\Helpers;
use Illuminate\Support\Facades\File;



class ParsingStringLua
{
    public array $translations = [];
    public function __construct($filePath, string $language = 'en'  )
    {
        if (!File::exists($filePath)) {
            throw new \Exception('Le fichier spécifié n\'existe pas.');
        }

        $luaContent = File::get($filePath);

        // Extraire les traductions en fonction de la langue choisie (par exemple, 'en' pour l'anglais)

        // Extractions basées sur le format Lua (exemple avec 'en' pour anglais)
        if (preg_match("/".$language."\s*=\s*{([^}]+)}/s", $luaContent, $matches)) {
            $this->translations = $this->parseLuaTranslations($matches[1]);
        }
    }

    public function getTranslation(string $key):?string
    {
        return $this->translations[$key]?? null;  // Si la clé n'est pas trouvée, renvoyer null. Si elle existe, renvoyer sa valeur.
    }

    public function parseLuaTranslations($translationString): array
    {
        $translations = [];

        // Extraction des paires clé-valeur comme mod_name = 'Mod Name'
        if (preg_match_all("/([a-zA-Z0-9_]+)\s*=\s*'([^']+)'/", $translationString, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $translations[$match[1]] = $match[2];  // 'mod_name' => 'Mod Name'
            }
        }

        return $translations;
    }
}
