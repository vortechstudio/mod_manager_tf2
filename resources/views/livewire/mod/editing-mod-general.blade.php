<div>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Statistiques du mod</h2>
            <div class="row">
                <div class="col">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Nombre de modèles</span>
                            <span>{{ $mdlCount }}</span>
                        </div>
                        <div class="separator border-2 border-black border-opacity-25 my-1"></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Nombre de fichier</span>
                            <span>{{ $totalFiles }}</span>
                        </div>
                        <div class="separator border-2 border-black border-opacity-25 my-1"></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Taille du dossier</span>
                            <span>{{ number_format($totalSize / 1048576, 2) }} Mo</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Images TGA du mod</span>
                            @if($imageTgaExists)
                                <iconify-icon icon="line-md:check-all" width="24" height="24"  style="color: #37ff00"></iconify-icon>
                            @else
                                <iconify-icon icon="line-md:close-circle" width="24" height="24"  style="color: #ff0000"></iconify-icon>
                            @endif
                        </div>
                        <div class="separator border-2 border-black border-opacity-25 my-1"></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Images Steam Workshop</span>
                            @if($workshopPreviewExists)
                                <iconify-icon icon="line-md:check-all" width="24" height="24"  style="color: #37ff00"></iconify-icon>
                            @else
                                <div class="d-flex align-items-center gap-1">
                                    <iconify-icon icon="line-md:close-circle" width="24" height="24"  style="color: #ff0000"></iconify-icon>
                                    <button class="btn btn-sm btn-info" wire:click="createWorkshopPreview">
                                        <span wire:loading.remove>Créer</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="separator border-2 border-black border-opacity-25 my-1"></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Images Mod.io</span>
                            @if($modioPreviewExists)
                                <iconify-icon icon="line-md:check-all" width="24" height="24"  style="color: #37ff00"></iconify-icon>
                            @else
                                <div class="d-flex align-items-center gap-1">
                                    <iconify-icon icon="line-md:close-circle" width="24" height="24"  style="color: #ff0000"></iconify-icon>
                                    <button class="btn btn-sm btn-info" wire:click="createModIoPreview">Créer</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
