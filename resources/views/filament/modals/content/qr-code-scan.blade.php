<div
    x-data="{
        qrScanner: null,
        isScanning: false,

        initScanner() {
            if (!window.Html5Qrcode) {
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/html5-qrcode';
                script.onload = () => this.startScanner();
                document.body.appendChild(script);
            } else {
                this.startScanner();
            }
        },

        async startScanner() {
            const scannerId = 'qr-reader';
            this.qrScanner = new Html5Qrcode(scannerId);

            try {
                await this.qrScanner.start(
                    { facingMode: 'environment' },
                    { fps: 10, qrbox: 250 },
                    (decodedText) => {
                        this.stopScanner();
                        this.open = false;
                        fetch('/absensi-scan', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ qr_code: decodedText })
                        })
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message);
                            location.reload();
                        })
                        .catch(err => {
                            alert('Gagal kirim absensi');
                            console.error(err);
                            location.reload();
                        });
                    },
                    (errorMessage) => {
                        // Jangan spam error normal dari scanner
                    }
                );
                this.isScanning = true;
            } catch (error) {
                console.error('Gagal start scanner:', error);
            }
        },

        stopScanner() {
            if (this.qrScanner && this.isScanning) {
                this.qrScanner.stop().then(() => {
                    this.qrScanner.clear();
                    this.qrScanner = null;
                    this.isScanning = false;

                    // Matikan kamera secara manual
                    const videoEl = document.querySelector('#qr-reader video');
                    if (videoEl && videoEl.srcObject) {
                        videoEl.srcObject.getTracks().forEach(track => track.stop());
                        console.log('[Scanner] Kamera dimatikan manual.');
                    }

                    console.log('Scanner benar-benar dihentikan');
                }).catch((err) => {
                    console.error('Gagal stop scanner:', err);
                });
            }
        }
    }"
    x-init="initScanner"
    @alpine:destroy="stopScanner"
>
    <div id="qr-reader" class="w-full h-[300px] rounded border shadow mx-auto"></div>
</div>
