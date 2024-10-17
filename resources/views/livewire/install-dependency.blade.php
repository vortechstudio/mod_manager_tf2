<div class="d-flex flex-center justify-content-center align-items-center">
    {{ $statusMessage }}
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">{{ $progress }}%</div>
    </div>
    @if($progress >= 100)
        <h1 class="text-success">Installation Terminer</h1>
    @endif
</div>
