<?php

namespace App\Livewire;

use App\Services\BinaryService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Native\Laravel\Facades\Window;
use Native\Laravel\Menu\Menu;

class InstallDependency extends Component
{
    public $progress = 0;
    public $statusMessage = '';

    public function mount()
    {
        $this->progress = 0;
        $this->statusMessage = 'Initialisation...';

        $this->progress = 10;
        $this->statusMessage = 'Vérification de l\'installation d\'ImageMagick...';

        if(!(new BinaryService)->checkImageMagick()) {
            $this->statusMessage = 'ImageMagick non trouvé, Téléchargement en cours...';
            (new BinaryService)->installImageMagick();
        }

        $this->progress = 60;
        $this->statusMessage = 'Vérification du ModValidator...';

        if(!(new BinaryService)->checkModValidator()) {
            $this->statusMessage = 'ModValidator non trouvé, Téléchargement en cours...';
            (new BinaryService)->installModValidator();
        }

        $this->progress = 100;
        $this->statusMessage = 'Installation terminée !';

        $win = Window::current();

        Window::close($win);

        Menu::new()
            ->register();

        Window::open()
            ->width(1280)
            ->height(720)
            ->route('home');
    }

    #[Layout('components.layouts.dependency')]
    public function render()
    {
        return view('livewire.install-dependency');
    }
}
