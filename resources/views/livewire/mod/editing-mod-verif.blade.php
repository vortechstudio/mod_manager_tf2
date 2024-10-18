<div>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Vérificateur de Mod avec l'outil Urban Games</h2>

            <button wire:click="runValidation" class="btn btn-primary mb-3">Lancer la validation</button>

            <!-- Résultats de validation -->
            @if(!empty($validationResults))
                <ul class="list-group">
                    @foreach($validationResults as $result)
                        <li class="list-group-item">{{ $result }}</li>
                    @endforeach
                </ul>
            @endif

            @if(session()->has('message'))
                <div class="alert alert-success mt-3">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</div>
