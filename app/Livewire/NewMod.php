<?php

namespace App\Livewire;

use App\Models\Config;
use Livewire\Component;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class NewMod extends Component
{
    public string $nameMod = '';
    public string $descMod = '';
    public string $severityModAdd = 'NONE';
    public string $severityModRemove = 'NONE';
    public string $authorsMod = '';
    public string $tagsMod = '';

    protected $rules = [
        "nameMod" => "required",
        "descMod" => "required",
        "severityModAdd" => "required",
        "severityModRemove" => "required",
        "authorsMod" => "required",
        "tagsMod" => "required"  // Add more fields as needed for your form. For example, "versionMod" or "websiteMod" etc.  //
    ];

        /**
     * Reads the configuration from a JSON file.
     *
     * This function attempts to read a configuration file located at 'config/config.json'.
     * If the file exists, it decodes the JSON content into an associative array and returns it.
     * If the file does not exist, it returns a set of default configuration values.
     *
     * @return array An associative array containing configuration settings. If the file is not found,
     *               it returns default values for 'temp_path' and 'staging_area'.
     */
    public function readConfig()
    {
        $configPath = base_path('config/config.json');  // Assuming the config.json file is in the config folder

        if (File::exists($configPath)) {
            return json_decode(File::get($configPath), true);
        }

        // Return default values if config.json does not exist
        return [
            'temp_path' => '/default/temp/path',
            'staging_area' => '/default/staging/area',
        ];
    }

        /**
     * Determines if a given file path is an absolute path.
     *
     * This function checks if the provided path is an absolute path
     * on either Windows or Unix-based systems.
     *
     * @param string $path The file path to be checked.
     *
     * @return bool Returns true if the path is absolute, false otherwise.
     */
    public function isAbsolutePath($path)
    {
        // Windows absolute path check (e.g., C:\)
        if (preg_match('/^[a-zA-Z]:\\\\/', $path)) {
            return true;
        }

        // Unix-based absolute path check (starts with "/")
        return $path[0] === '/';
    }

        /**
     * Translates text using the LibreTranslate API.
     *
     * This function sends a POST request to the LibreTranslate API with the provided text and target language.
     * It then extracts the translated text from the API response and returns it. If the translation fails,
     * it returns the original text.
     *
     * @param string $text The text to be translated.
     * @param string $targetLanguage The target language code (e.g., 'en' for English, 'fr' for French).
     *
     * @return string The translated text or the original text if translation fails.
     */
    public function translateText(string $text, string $targetLanguage)
    {
        $response = \Http::post('https://libretranslate.com/translate', [
            'q' => $text,
            'source' => 'auto',
            'target' => $targetLanguage,
            'format' => 'text'
        ]);

        return $response->json()['translatedText'] ?? $text;
    }

        /**
     * Creates a new mod directory structure in the specified temporary path.
     *
     * This function takes a mod name as a parameter, generates a unique directory name,
     * and creates the necessary subdirectories for the mod files. If the directory already exists,
     * it does nothing. If any error occurs during the directory creation, it flashes an error message
     * and returns null.
     *
     * @param string $nameMod The name of the mod for which the directory structure needs to be created.
     *
     * @return string|null The full path of the created mod directory, or null if an error occurred.
     */
    public function makeDirectories(string $nameMod)
    {

        $config = $this->readConfig();
        $tempPath = $config['temp_path'];

        $modDirectoryName = strtolower(str_replace(' ', '_', $nameMod)) . '_1';

        if($this->isAbsolutePath($tempPath)) {
            $modDirectory = $tempPath.DIRECTORY_SEPARATOR.$modDirectoryName;
        } else {
            $modDirectory = storage_path($tempPath.DIRECTORY_SEPARATOR.$modDirectoryName);
        }

        try {
            if(!File::exists($modDirectory)) {
                File::makeDirectory($modDirectory.'/res/models', 0755, true);
                File::makeDirectory($modDirectory.'/res/textures', 0755, true);
                File::makeDirectory($modDirectory.'/res/config', 0755, true);
                File::makeDirectory($modDirectory.'/res/textures/ui/icons', 0755, true);
                File::makeDirectory($modDirectory.'/res/textures/models', 0755, true);
            }

            return $modDirectory;
        }catch (FileException $exception) {
            flash()->addError($exception->getMessage(), 'Erreur de création de dossier');
            return null;
        }

    }

        /**
     * Saves the mod data by validating input, creating necessary directories,
     * generating configuration files, and opening the mod directory.
     *
     * This function validates the input data, creates a directory structure for the mod,
     * generates the mod.lua and strings.lua files with the provided and translated data,
     * copies a default image to the mod directory, and opens the directory in the file explorer.
     *
     * @return void
     */
    public function save()
    {
        $validatedData = $this->validate();
        $modDirectory = $this->makeDirectories($validatedData['nameMod']);

        if ($modDirectory === null) {
            return; // Stop if directory creation failed
        }

        // Convertir les auteurs en tableau
        $authorsArray = array_map('trim', explode(',', $validatedData['authorsMod']));
        $formattedAuthors = [];

        foreach ($authorsArray as $author) {
            $formattedAuthors[] = [
                'name' => $author,
                'role' => 'CREATOR',
            ];
        }

        // Convertir les tags en tableau
        $tagsArray = array_map('trim', explode(',', $validatedData['tagsMod']));

        // Générer le contenu du fichier mod.lua
        $luaContent = "
function data()
return {
	info = {
		minorVersion = 1,
		severityAdd = ".$validatedData['severityModAdd'].",
		severityRemove = ".$validatedData['severityModRemove'].",
		name = _('mod_name'),
		description = _('mod_description'),
		authors = ". json_encode($formattedAuthors, JSON_PRETTY_PRINT) . ",
		tags = ". json_encode($tagsArray, JSON_PRETTY_PRINT) .",
		visible = true,
	},
}
end
        ";

        // Créer le fichier mod.lua
        File::put($modDirectory . '/mod.lua', $luaContent);

        // Traduire automatiquement les éléments pour le fichier strings.lua
        $translatedDescriptionFR = $this->translateText($validatedData['descMod'], 'fr');
        $translatedDescriptionDE = $this->translateText($validatedData['descMod'], 'de');

        $translatedModNameFR = $this->translateText($validatedData['nameMod'], 'fr');
        $translatedModNameDE = $this->translateText($validatedData['nameMod'], 'de');

        // Générer le fichier strings.lua (traductions)
        $stringsContent = "
        return {
            en = {
                description = '{$validatedData['descMod']}',
                mod_name = '{$validatedData['nameMod']}'
            },
            fr = {
                description = '{$translatedDescriptionFR}',
                mod_name = '{$translatedModNameFR}'
            },
            de = {
                description = '{$translatedDescriptionDE}',
                mod_name = '{$translatedModNameDE}'
            }
        };
        ";

        File::put($modDirectory . '/strings.lua', $stringsContent);

        $sourceImagePath = public_path('images/image_00.tga');
        $destImagePath = $modDirectory.DIRECTORY_SEPARATOR.'image_00.tga';
        File::copy($sourceImagePath, $destImagePath);

        if (PHP_OS_FAMILY === 'Windows') {
            exec("explorer " . escapeshellarg($modDirectory));
        } elseif (PHP_OS_FAMILY === 'Linux') {
            exec("xdg-open " . escapeshellarg($modDirectory));
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            exec("open " . escapeshellarg($modDirectory));
        }

        flash()->addSuccess('Mod créé avec succès!');
    }

    public function render()
    {
        return view('livewire.new-mod');
    }
}
