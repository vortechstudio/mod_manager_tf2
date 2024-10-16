<?php

namespace App\Livewire\Core;

use App\Models\Config;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class Setting extends Component
{
    public string $tempPath = '';
    public string $stagingPath = '';

    public string $modIoId = '';
    public string $steamId = '';

    public function mount()
    {
        try {
            $config = $this->readConfig();
            $this->tempPath = $config['temp_path'];
            $this->stagingPath = $config['staging_path'];
            $this->modIoId = $config['mod_io_id'];
            $this->steamId = $config['steam_id'];
        } catch (\Exception $e) {
            flash()->addError($e->getMessage());
        }
    }

    public function save()
    {
        try {
            $config = [
                'temp_path' => $this->tempPath,
                'staging_path' => $this->stagingPath,
                'mod_io_id' => $this->modIoId,
                'steam_id' => $this->steamId,
            ];

            $this->writeConfig($config);
            flash()->addSuccess('Configuration sauvegardée avec succès');
        }catch (\Exception $e) {
            flash()->addError($e->getMessage());
        }
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
            'staging_path' => '',
            'mod_io_id' => '',
           'steam_id' => '',
        ];
    }

    private function writeConfig(array $config)
    {
        $configPath = base_path('config/config.json');
        File::put($configPath, json_encode($config, JSON_PRETTY_PRINT));
    }

    public function render()
    {
        return view('livewire.core.setting');
    }
}
