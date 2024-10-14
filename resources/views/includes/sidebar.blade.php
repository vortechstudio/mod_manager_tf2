<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 320px; height: 768px">
    <a href="{{ route('home') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="icon.png" style="width: 35px" class="me-4" alt="">
        <span class="fs-4">{{ config('app.name') }}</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link d-flex align-items-center gap-1 active" aria-current="page">
                <iconify-icon icon="line-md:home-twotone" width="24" height="24"></iconify-icon>
                Acceuil
            </a>
        </li>
        <li>
            <a href="#" class="nav-link d-flex align-items-center gap-1 text-white">
                <iconify-icon icon="line-md:folder-plus-twotone" width="24" height="24"></iconify-icon>
                Nouveau Mod
            </a>
        </li>
        <li>
            <a href="#" class="nav-link d-flex align-items-center gap-1 text-white">
                <iconify-icon icon="line-md:edit-full-twotone" width="24" height="24"></iconify-icon>
                Editer un Mod
            </a>
        </li>
        <li>
            <a href="#" class="nav-link d-flex align-items-center gap-1 text-white">
                <iconify-icon icon="line-md:image-twotone" width="24" height="24"></iconify-icon>
                Convertisseur TGA/DDS
            </a>
        </li>
        <li>
            <a href="#" class="nav-link d-flex align-items-center gap-1 text-white">
                <iconify-icon icon="line-md:check-list-3-twotone" width="24" height="24"></iconify-icon>
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
            <a href="{{ route('config') }}" class="text-white "><iconify-icon icon="line-md:cog-loop" width="24" height="24"></iconify-icon> </a>
            <a href="{{ route('core', ['action' => 'close']) }}" class="text-white "><iconify-icon icon="line-md:logout" width="24" height="24"></iconify-icon> </a>
        </div>
    </div>
</div>
