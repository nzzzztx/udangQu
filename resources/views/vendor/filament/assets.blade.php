@if (isset($data))
    <script>
        window.filamentData = @js($data)
    </script>
@endif

{{-- ✅ Tambahkan favicon --}}
<link rel="icon" type="image/png" href="{{ asset('images/logo-pandemo.png') }}">

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue)
            --{{ $cssVariableName }}:{{ $cssVariableValue }};
        @endforeach
    }
</style>

@once
    @push('scripts')
        {{-- Script QR code styling --}}
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
                            modalWasOpen = true;
                        }

                        if (!isOpen && modalWasOpen) {
                            const videoEl = document.querySelector('#qr-reader video');
                            if (videoEl && videoEl.srcObject) {
                                videoEl.srcObject.getTracks().forEach(track => track.stop());
                            }
                            modalWasOpen = false;
                        }
                    } else {
                        console.log('[Modal] Tidak ditemukan');
                    }
                }, 1000);
            });
        </script>
    @endpush
@endonce
