<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 320px; height: 768px">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="icon.png" style="width: 35px" class="me-4" alt="">
        <span class="fs-4">{{ config('app.name') }}</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="#" class="nav-link active" aria-current="page">
                <i class="fa-solid fa-home me-2" style="width: 40px;"></i>
                Acceuil
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="fa-solid fa-folder-plus me-2" style="width: 40px;"></i>
                Nouveau Mod
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="fa-solid fa-file-edit me-2" style="width: 40px;"></i>
                Editer un Mod
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="fa-solid fa-images me-2" style="width: 40px;"></i>
                Convertisseur TGA/DDS
            </a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                <i class="fa-solid fa-certificate me-2" style="width: 40px;"></i>
                Vérificateurs
            </a>
        </li>
    </ul>
    <hr>
    <div class="d-flex flex-row justify-content-between">
        <div>
            <span>Version:</span>
            <span>0.0.1</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('config') }}" class="text-white "><i class="fa-solid fa-cog"></i> </a>
            <a href="{{ route('core', ['action' => 'close']) }}" class="text-white "><i class="fa-solid fa-power-off"></i> </a>
        </div>
    </div>
</div>
