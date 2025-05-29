@if (isset($data))
    <script>
        window.filamentData = @js($data)
    </script>
@endif

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>
@once
    @push('scripts')
        {{-- <script src="https://cdn.jsdelivr.net/npm/qrcode@1.4.4/build/qrcode.min.js"></script> --}}

        <script src="https://cdn.jsdelivr.net/npm/qr-code-styling@1.5.0/lib/qr-code-styling.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
       <script>
    document.addEventListener('alpine:init', () => {
        let modalWasOpen = false;

        setInterval(() => {
            const modal = document.querySelector('.fi-modal');

            if (modal) {
                const isOpen = modal.classList.contains('fi-modal-open');

                if (isOpen && !modalWasOpen) {
                    // console.log('[Modal] Dibuka');
                    modalWasOpen = true;
                }

                if (!isOpen && modalWasOpen) {
                    // console.log('[Modal] Ditutup, reload halaman...');
                    const videoEl = document.querySelector('#qr-reader video');
                    if (videoEl && videoEl.srcObject) {
                        videoEl.srcObject.getTracks().forEach(track => track.stop());
                        // console.log('[Scanner] Kamera dimatikan manual.');
                    }
                    modalWasOpen = false;
                    // setTimeout(() => location.reload(), 500);
                }
            } else {
                console.log('[Modal] Tidak ditemukan');
            }
        }, 1000);
    });
</script>



    @endpush
@endonce

