<?php

namespace App\Livewire\Core;

use App\Services\BinaryService;
use App\Services\SteamWorkshop;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class Welcome extends Component
{
    public $modStats = [];

    public function mount()
    {
        $this->modStats['created'] = $this->getModCount('created');
        $this->modStats['modified'] = $this->getModCount('modified');
        $this->modStats['validated'] = $this->getModCount('validated');
        $this->modStats['total'] = $this->getModCount('total');
        $this->checkDependencies();
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
        ];
    }

    public function getModCount(string $symbol)
    {
        $config = $this->readConfig();
        $stagingPath = $config['staging_path'];
        $tempPath = $config['temp_path'];
        switch ($symbol) {
            case 'created':
                return File::directories($tempPath) ? count(File::directories($tempPath)) : 0;
            case 'modified':
                $directories = File::directories($tempPath);
                $modifiedMod = 0;

                foreach ($directories as $directory) {
                    if (File::exists($directory . DIRECTORY_SEPARATOR . 'version.txt')) {
                        $modifiedMod++;
                    }
                }
                return $modifiedMod;

            case 'validated':
                return File::directories($stagingPath) ? count(File::directories($stagingPath)) : 0;

            case 'total':
                return 0;

        }
    }

    public function checkDependencies()
    {
        if(!(new BinaryService)->checkImageMagick()) {
            flash()->addInfo('Aucune installation de ImageMagick trouvée. Téléchargement en cours...');
            (new BinaryService)->installImageMagick();
        }

        if(!(new BinaryService)->checkModValidator()) {
            flash()->addInfo('Aucune installation de Mod Validator trouvée. Téléchargement en cours...');
            (new BinaryService)->installModValidator();
        }
    }

    public function render()
    {
        return view('livewire.core.welcome');
    }
}
