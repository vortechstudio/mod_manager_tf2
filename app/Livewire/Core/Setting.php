<?php

namespace App\Livewire\Core;

use App\Models\Config;
use Livewire\Component;

class Setting extends Component
{
    public string $tempPath = '';
    public string $stagingPath = '';

    public function mount()
    {
        try {
            $this->tempPath = Config::where('name', 'temp_path')->firstOrFail()->value;
            $this->stagingPath = Config::where('name', 'staging_path')->firstOrFail()->value;
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
        }
    }

    public function save()
    {
        try {
            $tempConfig = Config::where('name', 'temp_path')->first();
            $stagingConfig = Config::where('name', 'staging_path')->first();

            if ($tempConfig && $stagingConfig) {
                $tempConfig->value = $this->tempPath;
                $tempConfig->save();

                $stagingConfig->value = $this->stagingPath;
                $stagingConfig->save();

                flash()->addSuccess("Configuration Terminer !");
            } else {
                throw new \Exception('Error system');
            }
        } catch (\Exception $exception) {
            flash()->addError($exception->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.core.setting');
    }
}
