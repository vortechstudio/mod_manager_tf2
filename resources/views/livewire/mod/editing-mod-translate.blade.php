<div>
    <form wire:submit="saveTranslations">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Traductions du mod</h3>
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#addKey">Nouvelle clef/valeur</button>
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#addLang">Nouvelle Langue</button>
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#autoTrad">Traduction</button>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Clé de traduction</th>
                            @foreach($languages as $lang)
                                <th>
                                    {{ strtoupper($lang) }}
                                    <button wire:click="removeLanguage('{{ $lang }}')" class="btn btn-danger btn-sm">X</button>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ligne pour mod_name -->
                        <tr>
                            <td>mod_name</td>
                            @foreach($languages as $lang)
                                <td>
                                    <input type="text" class="form-control" wire:model="translations.{{ $lang }}.mod_name">
                                </td>
                            @endforeach
                        </tr>

                        <!-- Ligne pour mod_description -->
                        <tr>
                            <td>mod_description</td>
                            @foreach($languages as $lang)
                                <td>
                                    <textarea class="form-control" wire:model="translations.{{ $lang }}.mod_description"></textarea>
                                </td>
                            @endforeach
                        </tr>
                        @foreach($customKeys as $customKey)
                        <tr>
                            <td>
                                {{ $customKey }}
                                <button wire:click="removeKey('{{ $customKey }}')" class="btn btn-danger btn-sm">X</button>

                            </td>
                            @foreach($languages as $lang)
                                <td>
                                    <input type="text" class="form-control" wire:model="translations.{{ $lang }}.{{ $customKey }}">
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="btn btn-success" type="submit">Sauvegarder</button>

                <!-- Messages de succès ou d'erreur -->
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
            </div>
        </div>
    </form>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="addKey" aria-labelledby="offcanvasBottomLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Nouvelle Clef / Valeur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body small">
          <div class="form-group mb-3">
              <label for="newKey" class="form-label">Nouvelle clé</label>
              <input type="text" id="newKey" wire:model="newKey" class="form-control mb-2" placeholder="Entrez la clé (par ex: mod_author)">
              <button class="btn btn-primary" type="button" wire:click="addNewKey">Ajouter une nouvelle paire clé/valeur</button>
          </div>
      </div>
    </div>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="addLang" aria-labelledby="offcanvasBottomLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Nouvelle Langue</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body small">
          <div class="form-group mb-3">
              <label for="newLanguage" class="form-label">Ajouter une nouvelle langue :</label>
              <input type="text" id="newLanguage" wire:model="newLanguage" class="form-control mb-2" placeholder="Code langue (ex: es)">
              <button class="btn btn-primary" wire:click="addLanguage">Ajouter la langue</button>
          </div>
      </div>
    </div>
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="autoTrad" aria-labelledby="offcanvasBottomLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Traduction automatique</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body small">
        <div class="form-group mb-3">
            <label for="sourceLanguage" class="form-label">Langue source pour la traduction :</label>
            <select id="sourceLanguage" class="form-control mb-2" wire:model="sourceLanguage">
                @foreach($languages as $lang)
                    <option value="{{ $lang }}">{{ strtoupper($lang) }}</option>
                @endforeach
            </select>
            <button class="btn btn-info" wire:click="translateAutomatically">Traduire automatiquement à partir de {{ strtoupper($sourceLanguage) }}</button>
        </div>
      </div>
    </div>

</div>

