<x-filament::page>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">

        {{-- Jumlah Karyawan --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Jumlah Karyawan
            </div>
            <div class="text-3xl mt-2 text-primary-600 dark:text-primary-400">
                {{ $this->getJumlahKaryawan() }}
            </div>
        </x-filament::card>

        {{-- Absensi Hari Ini --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Absensi Hari Ini
            </div>
            <div class="text-3xl mt-2 text-success-600 dark:text-success-400">
                {{ $this->getAbsensiHariIni() }}
            </div>
        </x-filament::card>

        {{-- Persentase Kehadiran --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Persentase Kehadiran
            </div>
            <div class="text-3xl mt-2 text-indigo-600 dark:text-indigo-400">
                {{ $this->getPersentaseHadir() }}%
            </div>
        </x-filament::card>

        {{-- Tanggal Hari Ini --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Tanggal Hari Ini
            </div>
            <div class="text-2xl mt-2 text-gray-700 dark:text-gray-300">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </x-filament::card>

    </div>

    {{-- Statistik Keuangan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

        {{-- Pemasukan Bulan Ini --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Pemasukan Bulan Ini
            </div>
            <div class="text-2xl mt-2 text-green-600 dark:text-green-400">
                Rp {{ number_format($this->getTotalPemasukan(), 0, ',', '.') }}
            </div>
        </x-filament::card>

        {{-- Pengeluaran Bulan Ini --}}
        <x-filament::card
            class="min-h-[100px] border border-gray-200 dark:border-gray-700 shadow-sm transition hover:scale-[1.01] duration-150">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                Pengeluaran Bulan Ini
            </div>
            <div class="text-2xl mt-2 text-red-600 dark:text-red-400">
                Rp {{ number_format($this->getTotalPengeluaran(), 0, ',', '.') }}
            </div>
        </x-filament::card>

    </div>

    {{-- Grafik Keuangan --}}
    <div class="mt-10">
        <x-filament::card class="border border-gray-200 dark:border-gray-700 shadow-sm">
            <div class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">
                Grafik Keuangan
            </div>

            @livewire(\App\Filament\Widgets\FinancialChart::class)
        </x-filament::card>
    </div>

</x-filament::page>
