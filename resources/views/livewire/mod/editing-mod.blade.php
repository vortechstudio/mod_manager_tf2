<div class="container-fluid mt-1" style="width: 100%">
    <div class="card mb-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span>{{ $mod['name'] }}</span>
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <button wire:click="return" class="btn btn-secondary">
                        Retour
                    </button>
                    <button wire:click="save" class="btn btn-success">
                        Sauvegarder l'édition
                    </button>
                    <button wire:click="close" class="btn btn-danger">
                        Fermer l'édition
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#about">
                                <iconify-icon icon="line-md:home-md-alt-twotone" width="24" height="24"></iconify-icon>
                                Général
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#traductions">
                                <iconify-icon icon="ion:language-sharp" width="24" height="24"></iconify-icon>
                                Traductions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#conv">
                                <iconify-icon icon="material-symbols:table-convert" width="24" height="24"></iconify-icon>
                                Convertisseur TGA/DDS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#verif">
                                <iconify-icon icon="line-md:check-list-3" width="24" height="24"></iconify-icon>
                                Vérificateur
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="about" role="about">
                    <livewire:mod.editing-mod-general :modPath="$modPath" />
                </div>
                <div class="tab-pane fade" id="traductions" role="tabpanel">
                    <livewire:mod.editing-mod-translate :modPath="$modPath" />
                </div>
                <div class="tab-pane fade" id="conv" role="tabpanel">
                    <livewire:mod.editing-mod-convert :modPath="$modPath" />
                </div>
            </div>
        </div>
    </div>
</div>
