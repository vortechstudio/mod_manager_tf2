<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast align-items-center text-white bg-{{ $type }} border-0"
         id="livewire-toast"
         role="alert"
         aria-live="assertive"
         aria-atomic="true"
         x-data="{ show: @entangle('showToast') }"
         x-init="
            const toastEl = document.getElementById('livewire-toast');
            const bsToast = new bootstrap.Toast(toastEl);
            if (show) {
                bsToast.show();
            }
            $watch('show', value => {
                if (value) {
                    bsToast.show();
                } else {
                    bsToast.hide();
                }
            });
         "
         @keydown.escape.window="show = false"
    >
        <div class="d-flex">
            <div class="toast-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" @click="show = false"></button>
        </div>
    </div>
</div>
