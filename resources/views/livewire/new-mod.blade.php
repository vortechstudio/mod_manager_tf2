<div class="card m-2 w-100 overflow-auto">
    <div class="card-body">
        <h2 class="card-title">Nouveau Mod</h2>
        <div class="alert alert-primary" role="alert">
            La création d'un nouveau mod par ce formulaire va permettre de créer le dossier correspondant dans le dossier temporaire définie, va générer le fichier mod.lua en conséquence et créer les dossiers de premiers niveaux nécessaires.<br>
            <b>Avertissement:</b> Cette fonction est encore en phase béta et peut être amener à être modifier en conséquence, si vous rencontrer un souci avec cette fonction cliquer <a href="https://github.com/vortechstudio/mod_manager_tf2/issues/new?assignees=maximemockelyn&labels=Bugs&projects=&template=bug_report.md&title=%5BBUG%5D+%3A">ici</a>
        </div>
        <form action="" wire:submit="save">
            <div class="mb-3">
                <label for="nameMod" class="form-label">Nom du Mod <span class="text-danger">*</span></label>
                <input type="text" id="nameMod" name="nameMod" wire:model="nameMod" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="authorsMod" class="form-label">Auteurs du Mod <span class="text-danger">*</span></label>
                <input type="text" id="authorsMod" name="authorsMod" wire:model="authorsMod" class="form-control" required>
                <span class="fst-italic">Si plusieurs auteurs, les séparés par une virgule</span>
            </div>
            <div class="mb-3">
                <label for="tagsMod" class="form-label">Tags du Mod <span class="text-danger">*</span></label>
                <input type="text" id="tagsMod" name="tagsMod" wire:model="tagsMod" class="form-control" required>
                <span class="fst-italic">Si plusieurs tags, les séparés par une virgule</span>
            </div>
            <div class="mb-3">
                <label for="descMod" class="form-label">Description du Mod <span class="text-danger">*</span></label>
                <textarea id="descMod" name="descMod" wire:model="descMod" class="form-control" rows="5" required></textarea>
            </div>
            <div class="row">
                <div class="col">
                    <label for="severityModAdd" class="form-label">Sévérité (Ajout) <span class="text-danger">*</span></label>
                    <select id="severityModAdd" name="severityModAdd" wire:model="severityModAdd" class="form-select">
                        <option value="NONE">NONE</option>
                        <option value="WARNING">WARNING</option>
                        <option value="CRITICAL">CRITICAL</option>
                    </select>
                </div>
                <div class="col">
                    <label for="severityModRemove" class="form-label">Sévérité (Suppression) <span class="text-danger">*</span></label>
                    <select id="severityModRemove" name="severityModRemove" wire:model="severityModRemove" class="form-select">
                        <option value="NONE">NONE</option>
                        <option value="WARNING">WARNING</option>
                        <option value="CRITICAL">CRITICAL</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-success w-100" wire:loading.class="d-none">Valider</button>
                <button class="btn btn-success w-100 disabled" disabled wire:loading>
                    <div class="spinner-grow" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    Création en cours...
                </button>
            </div>
        </form>
    </div>
</div>

