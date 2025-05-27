<!-- ✅ Ganti dengan versi qrcode.js (bukan .min.js) -->

{{-- <div class="inline-flex items-center justify-center flex-col" x-data="{ qrText: @js($qrText) }">
    <img  id="qrImage" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPoAAAD6AQMAAACyIsh+AAAABlBMVEX///8AAABVwtN+AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAA+0lEQVRoge3YyRGDMAwFUM24AEpy65REAZ5RbEleIMQLuXD4OiQgv5PwIiBCIF4XG1vs8Yr8QZQTAWAN2D/v5AzspwGAeSBllbT9bFJ5gKcgpwH+BWnSUvdZAAyApSNgHuwPAB1QjySZr6FzZgH0QBM2aX8HwAA0693HC6NbAFgCG+cCl40g7QGRAjwBTle8ppuuE2AepDF5/yGduaJK+QHmgY7lNlMaJj4cwDpoaCi90mWnBZgBtU3Se1cqD7AISutel/9hHzsAFgFfX8yJNAfwDKQ7r3vofakBJoFM3+aE+n4WAAMgUUutR5JngEVwPpJuSg0wBxCIV8UHFY2o1XyJ7FMAAAAASUVORK5CYII=" alt="QR Code">
</div> --}}
<!-- Pastikan script QRCode sudah terload -->
<!-- ✅ Gunakan CDN yang benar-benar expose QRCode -->
<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.js"></script>
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
</div>
