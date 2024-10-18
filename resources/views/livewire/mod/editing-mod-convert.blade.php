<div>
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Conversion TGA / DDS</h4>
        <h4>Fichiers TGA disponibles :</h4>
            <form wire:submit.prevent="convertSelectedFiles">
                <ul class="list-unstyled">
                    @isset($tgaFiles)
                        <li>Aucun fichier TGA à convertir</li>
                    @else
                        @foreach($tgaFiles as $file)
                            <li>
                                <input type="checkbox" class="form-check-input" wire:model="selectedFiles" value="{{ $file }}">
                                {{ $file }}
                            </li>
                        @endforeach
                    @endif
                </ul>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">Convertir les fichiers sélectionnés</button>
                    <button type="button" class="btn btn-secondary" wire:click="convertSelectedFiles">Tout convertir</button>
                </div>
            </form>

            @if(session()->has('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @endif
      </div>
    </div>
</div>
