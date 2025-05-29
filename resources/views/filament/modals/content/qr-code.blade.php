
<!-- Script QRCode  -->
{{-- <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.js"></script>
<div
    x-data="{
        qrText: @js($qrText) +'karyawan id:'+@js($karyawan_id),
        // console.log('QR Text:'+ qrText),

        async initQR() {
            // Inject script jika QRCode belum ada
            if (typeof QRCode === 'undefined') {
                await this.injectScript('https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js');
            }

            const qrDiv = document.getElementById('qrcode-container');
            qrDiv.innerHTML = '';

            new QRCode(qrDiv, {
                text: this.qrText,
                width: 250,
                height: 250,
                correctLevel: 3
            });

            setTimeout(() => {
                const canvas = qrDiv.querySelector('canvas');
                if (canvas) {
                    const img = document.getElementById('qrImage');
                    img.src = canvas.toDataURL('image/png');
                }
            }, 200);
        },

        injectScript(src) {
            return new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = src;
                script.onload = resolve;
                script.onerror = reject;
                document.body.appendChild(script);
            });
        },

        downloadQR() {
            const img = document.getElementById('qrImage');
            const link = document.createElement('a');
            link.href = img.src;
            link.download = 'qr_code.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }"
    x-init="initQR()"
    class="inline-flex items-center justify-center flex-col"
>
    <div id="qrcode-container" class="hidden"></div>
    <img id="qrImage" alt="QR Code" class="rounded shadow w-[250px] h-[250px]" />

    <button
        type="button"
        title="Download QR Code"
        class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 text-sm mt-2"
        @click="downloadQR"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
        </svg>
        Download QR Code
    </button>
</div> --}}

<div
    x-data="() => ({
        qrText: @js($qrText),
        qrCode: null,

        initQR() {
            this.qrCode = new QRCodeStyling({
                width: 300,
                height: 300,
                type: 'canvas',
                data: this.qrText,
                image: '', // optional logo
                margin: 10,
                dotsOptions: {
                    color: '#000',
                    type: 'square'
                },
                // cornersSquareOptions: {
                //     type: 'extra-rounded' // or 'dot', 'square'
                // },
                backgroundOptions: {
                    color: '#fff',
                }
            });

            this.qrCode.append(document.getElementById('qrcode-container'));

            // Generate image for download
            this.qrCode.getRawData('png').then(blob => {
                const img = document.getElementById('qrImage');
                img.src = URL.createObjectURL(blob);
            });
        },

        downloadQR() {
            this.qrCode.download({ name: 'qr_code', extension: 'png' });
        }
    })"
    x-init="initQR"
    class="inline-flex items-center justify-center flex-col"
>
    <div id="qrcode-container" class="hidden"></div>
    <img id="qrImage" alt="QR Code" class="rounded shadow w-[250px] h-[250px]" />

    <button
        type="button"
        @click="downloadQR"
        class="text-blue-600 hover:text-blue-800 text-sm mt-2"
    >
        Download QR Code
    </button>
</div>

