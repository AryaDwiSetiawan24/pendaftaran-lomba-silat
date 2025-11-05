<!-- Alert -->
@foreach (['success' => 'green', 'failed' => 'yellow', 'error' => 'red'] as $type => $color)
    @if (session($type))
        <div id="{{ $type }}Alert"
            class="fixed top-20 right-4 bg-{{ $color }}-500 text-white px-5 py-4 rounded-lg shadow-lg flex items-center gap-3 z-50">
            <i class="uil {{ $type == 'success' ? 'uil-check-circle' : 'uil-exclamation-triangle' }} text-2xl"></i>
            <div>
                <p class="font-semibold capitalize">{{ $type }}</p>
                <p class="text-sm">{{ session($type) }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-3 hover:text-gray-200">
                <i class="uil uil-times text-xl"></i>
            </button>
        </div>
    @endif
@endforeach

<script>
    setTimeout(() => {
        ['successAlert', 'failedAlert', 'errorAlert'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = 0;
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 4000);
</script>
