<div class="d-flex flex-row align-items-center justify-content-between bg-dark bg-gradient bg-opacity-25 px-1" style="height: 40px">
    <span class="fs-5">{{ config('app.name') }}</span>
    <div class="d-flex flex-row justify-content-center align-items-center ps-1 text-danger">
        <a href="{{ route('core', ['action' => 'reduce']) }}" class="frameButton fmb_reduct me-2">
            <i class="fa-solid fa-window-minimize"></i>
        </a>
        <a href="{{ route('core', ['action' => 'maximize']) }}" class="frameButton fmb_maximize me-2">
            <i class="fa-solid fa-window-maximize"></i>
        </a>
        <a href="{{ route('core', ['action' => 'close']) }}" class="frameButton fmb_close bg-hover-danger">
            <i class="fa-solid fa-window-close"></i>
        </a>
    </div>
</div>
