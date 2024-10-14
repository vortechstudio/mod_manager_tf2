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
        $this->tempPath = Config::where('name', 'temp_path')->first()->value;
        $this->stagingPath = Config::where('name', 'staging_path')->first()->value;
    }

    public function save()
    {
        try {
            Config::where('name', 'temp_path')->first()
                ->update([
                    'value' => $this->tempPath
                ]);

            Config::where('name', 'staging_path')->first()
                ->update([
                    'value' => $this->stagingPath
                ]);
            $this->dispatch('showToast', 'success', 'Configuration terminer !');
        }catch (\Exception $exception) {
            $this->dispatch('showToast', 'danger', $exception->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.core.setting');
    }
}
