<div>
    <div class="card mb-2">
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
                                        <span wire:loading>
                                            <div class="spinner-grow" role="status">
                                              <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
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
                                    <button class="btn btn-sm btn-info" wire:click="createModIoPreview">
                                        <span wire:loading.remove>Créer</span>
                                        <span wire:loading>
                                            <div class="spinner-grow" role="status">
                                              <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Edition des informations du mod</h3>
            <form wire:submit='editing'>
                <div class="mb-3">
                    <label for="nameMod" class="form-label">Nom du Mod</label>
                    <input type="text" id="nameMod" class="form-control" wire:model.live="modData.name">
                </div>
                <div class="mb-3">
                    <label for="nameMod" class="form-label">Description du Mod</label>
                    <textarea id="descMod" class="form-control" wire:model.live="modData.description"></textarea>
                </div>
                <div class="mb-3">
                    <label for="tagsMod" class="form-label">Tags du Mod</label>
                    <input type="text" id="tagsMod" class="form-control" wire:model.live="modData.tags">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="modSeverityAdd" class="form-label">Sévérité à l'ajout</label>
                        <select id="modSeverityAdd" wire:model.live='modData.severityAdd' class="form-control">
                            <option value="NONE">NONE</option>
                            <option value="WARNING">WARNING</option>
                            <option value="CRITICAL">CRITICAL</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="modSeverityRemove" class="form-label">Sévérité à la suppression</label>
                        <select id="modSeverityRemove" wire:model.live='modData.severityRemove' class="form-control">
                            <option value="NONE">NONE</option>
                            <option value="WARNING">WARNING</option>
                            <option value="CRITICAL">CRITICAL</option>
                        </select>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="authors" class="form-label">Auteurs</label>
                    <div class="d-flex flex-column">
                        @foreach ($modData['authors'] ?? [] as $i => $author)
                        <div class="d-flex justify-content-between align-items-center gap-1 mb-1">
                            <input type="text" wire:model='modData.authors.{{ $i}}.name' class="form-control">
                            <select wire:model="modData.authors.{{ $i }}.role" class="form-control">
                                <option value="CREATOR">Créateur</option>
                                <option value="CONTRIBUTOR">Contributeur</option>
                            </select>
                            <button type="button" wire:click="removeAuthor({{ $i }})" class="btn btn-sm btn-danger">
                                <iconify-icon icon="line-md:remove" width="24" height="24"></iconify-icon>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" wire:click="addAuthor" class="btn btn-primary">Ajouter un auteur</button>
                </div>
            </form>
        </div>
    </div>
</div>
