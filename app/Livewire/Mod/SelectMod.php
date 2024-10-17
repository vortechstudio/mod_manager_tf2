<?php

namespace App\Livewire\Mod;

use Illuminate\Support\Facades\File;
use Livewire\Component;

class SelectMod extends Component
{
    public string $tempPath = '';
    public $mods = [];
    public $selectedMod = null;
    public $modDetails = [];

    public function mount()
    {
        $this->tempPath = $this->readConfig()['temp_path'];
        // Lister uniquement les mods sans 'version.txt' dans le dossier temporaire
        $this->mods = $this->listModsInTemp();
    }

    private function readConfig()
    {
        $configPath = base_path('config/config.json');
        if (File::exists($configPath)) {
            return json_decode(File::get($configPath), true);
        }

        // Return empty values if config file does not exist
        return [
            'temp_path' => '',
        ];
    }

    private function listModsInTemp()
    {
        $tempPath = $this->tempPath ?? '';

        if (empty($tempPath) || !File::exists($tempPath)) {
            return [];
        }

        $mods = [];
        foreach (File::directories($tempPath) as $dir) {
            if (!File::exists($dir . '/version.txt')) {
                // Vérifie l'absence de version.txt
                $mods[] = [
                    'name' => $this->getModName($dir),
                    'path' => $dir,
                    'status' => 'Disponible pour édition',
                ];
            }
        }

        return $mods;
    }

    public function getModName($dir)
    {
        $modLuaPath = $dir . '/mod.lua';
        if (File::exists($modLuaPath)) {
            // Extraire le nom du mod à partir du fichier mod.lua
            $content = File::get($modLuaPath);
            if (preg_match("/name\s*=\s*'([^']+)'/", $content, $matches)) {
                return $matches[1];
            }
        }

        return basename($dir);  // Retourne le nom du dossier si mod.lua est absent
    }

    public function render()
    {
        return view('livewire.mod.select-mod', ['mods' => $this->mods]);
    }
}
