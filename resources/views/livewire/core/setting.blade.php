<div class="card m-2 w-100">
    <div class="card-body">
        <h2 class="card-title">Configuration du programme</h2>
        <form action="" wire:submit="save">
            <div class="mb-3">
                <label for="tempPath" class="form-label">Dossier temporaire</label>
                <input type="text" class="form-control" id="tempPath" wire:model="tempPath" placeholder="Dossier temporaire">
            </div>
            <div class="mb-3">
                <label for="stagingPath" class="form-label">Dossier Staging Area</label>
                <input type="text" class="form-control" id="stagingPath" wire:model="stagingPath" placeholder="Dossier Staging Area">
            </div>
            <div class="d-flex flex-end">
                <button type="submit" class="btn btn-success">Valider</button>
            </div>
        </form>
    </div>
</div>
