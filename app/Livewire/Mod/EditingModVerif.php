<?php

namespace App\Livewire\Mod;

use Livewire\Component;

class EditingModVerif extends Component
{
    public $modPath;  // Chemin du mod
    public $validationResults = [];  // Stocke les résultats des vérifications

    public function mount($modPath)
    {
        $this->modPath = $modPath;
    }

    public function runValidation()
    {
        // Réinitialiser les résultats de validation
        $this->validationResults = [];

        // Exécuter le vérificateur de mod fourni par Urban Games
        $this->runModValidator();

        session()->flash('message', 'Validation terminée avec le vérificateur Urban Games !');
    }

    private function runModValidator()
    {
        // Spécifier le chemin du vérificateur fourni par Urban Games
        $validatorPath = public_path('bin/modvalidator/mod_validator.exe');  // Exemple de chemin vers l'exécutable

        // Exécuter le vérificateur avec le chemin du mod en paramètre
        $command = "$validatorPath \"{$this->modPath}\" --fix-mipmaps --nopause";
        $output = shell_exec($command);  // Exécuter la commande et capturer la sortie

        // Stocker les résultats de validation
        if ($output) {
            $this->validationResults = explode("\n", trim($output));
        } else {
            $this->validationResults[] = "Erreur : Impossible d'exécuter le vérificateur.";
        }
    }

    public function render()
    {
        return view('livewire.mod.editing-mod-verif');
    }
}
