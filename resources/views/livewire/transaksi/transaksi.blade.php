<div class="page-heading">

    <div class="page-title mb-3">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                {{-- Judul Halaman --}}
                <h3>Transaksi</h3>

                {{-- Subjudul --}}
                <p class="text-subtitle text-muted">Transaksi menggunakan barcode atau input manual.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                {{-- Breadcumb --}}
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row g-2 g-lg-3">
            
            {{-- Kolom Kiri: Scanner & Produk --}}
            <div class="col-12 col-lg-8">
                {{-- Scanner Card --}}
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <h4 class="mb-3">Scan Produk</h4>

                        <div id="reader" class="border rounded p-2 p-md-3 mb-3" style="min-height: 300px;" wire:ignore></div>

        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            // Variable global untuk menyimpan instance scanner
            let scanner = null;
            // Flag untuk mencegah scan berulang
            let canScan = true;
            // Flag untuk mencegah inisialisasi berulang
            let isInitializing = false;
            // Flag untuk tracking apakah scanner sudah diinisialisasi
            let scannerInitialized = false;

            // Callback ketika QR/barcode berhasil di-scan
            function onScanSuccess(decodedText) {
                if (!canScan) return; // Cegah scan berulang
                canScan = false; // Disable scanning sementara

                // Kirim hasil scan ke method Livewire tanpa menutup scanner
                @this.call('barcodeScanned', decodedText);

                // Re-enable scanning setelah delay singkat untuk mencegah scan berulang dari kode yang sama
                setTimeout(() => {
                    canScan = true;
                }, 2000); // Delay 2 detik sebelum bisa scan lagi
            }

            // Inisialisasi scanner baru
            function initScanner() {
                // Cegah inisialisasi berulang
                if (isInitializing || scannerInitialized) {
                    return;
                }

                isInitializing = true;

                // Bersihkan scanner lama jika ada
                if (scanner) {
                    try {
                        scanner.clear();
                        scanner = null;
                        scannerInitialized = false;
                    } catch (e) {
                        console.log('Error clearing existing scanner:', e);
                    }
                }

                // Pastikan element reader ada dan kosong
                const readerElement = document.getElementById('reader');
                if (!readerElement) {
                    isInitializing = false;
                    return;
                }

                // Bersihkan konten reader sebelum inisialisasi
                readerElement.innerHTML = '';

                try {
                    // Buat instance scanner baru dengan konfigurasi
                    scanner = new Html5QrcodeScanner("reader", {
                        fps: 10, // Frame per second untuk scanning
                        qrbox: {
                            width: 200,
                            height: 200
                        } // Ukuran area scan
                    });

                    scanner.render(onScanSuccess); // Render scanner dengan callback
                    scannerInitialized = true;
                } catch (e) {
                    console.log('Error initializing scanner:', e);
                } finally {
                    isInitializing = false;
                }
            }

            // Setup scanner dengan pengecekan DOM ready
            function setupScanner() {
                // Cegah setup berulang jika scanner sudah aktif
                if (scannerInitialized && scanner) {
                    return;
                }

                if (document.getElementById('reader')) { // Pastikan element reader ada
                    setTimeout(initScanner, 100); // Delay singkat untuk DOM stability
                }
            }

            // Cleanup function untuk membersihkan scanner
            function cleanupScanner() {
                if (scanner) {
                    try {
                        scanner.clear();
                        scanner = null;
                        scannerInitialized = false;
                        isInitializing = false;
                    } catch (e) {
                        console.log('Error during cleanup:', e);
                    }
                }

                // Bersihkan element reader
                const readerElement = document.getElementById('reader');
                if (readerElement) {
                    readerElement.innerHTML = '';
                }
            }

            // Event listener untuk load pertama kali
            document.addEventListener("DOMContentLoaded", function() {
                // Bersihkan dulu sebelum setup
                cleanupScanner();
                setupScanner();
            });

            // Event listener untuk navigasi Livewire (wire:navigate)
            document.addEventListener("livewire:navigated", function() {
                // Bersihkan scanner lama sebelum setup yang baru
                cleanupScanner();
                setTimeout(setupScanner, 200); // Delay lebih lama untuk navigasi
            });

            // Cleanup saat halaman akan ditinggalkan
            document.addEventListener("livewire:navigating", function() {
                cleanupScanner();
            });

            // Listen event reset dari Livewire component
            Livewire.on('resetScanner', () => {
                cleanupScanner(); // Bersihkan scanner dulu

                setTimeout(() => {
                    canScan = true; // Enable scanning kembali
                    initScanner(); // Inisialisasi ulang scanner
                }, 1500); // Delay untuk memberi waktu proses sebelumnya selesai
            });

            // Listen event untuk keep scanner alive setelah scan berhasil
            Livewire.on('keepScannerAlive', () => {
                // Pastikan scanner tetap aktif dan ready untuk scan berikutnya
                if (!scannerInitialized || !scanner) {
                    setTimeout(() => {
                        canScan = true;
                        initScanner();
                    }, 500);
                } else {
                    canScan = true; // Re-enable scanning
                }
            });

            // Cleanup saat window akan di-unload (fallback)
            window.addEventListener('beforeunload', cleanupScanner);
        </script>
                    </div>
                </div>

                {{-- Produk Search Card --}}
                <div class="card shadow mb-3">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Cari & Pilih Produk</h5>
                        <div class="d-flex flex-column flex-md-row gap-2 mb-3">
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..." class="form-control flex-grow-1">
                            @if ($search)
                                <button wire:click="clearSearch" class="btn btn-secondary btn-sm">
                                    Hapus
                                </button>
                            @endif
                        </div>

                        <div class="row g-2">
                            @foreach ($barang as $produk)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="card h-100">
                                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 100px;">
                                            @if ($produk->foto)
                                                <img src="{{ Storage::url($produk->foto) }}" alt="{{ $produk->nama }}" class="img-fluid rounded" style="max-height: 100px;">
                                            @else
                                                <svg class="text-muted" width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title text-truncate fs-7">{{ $produk->nama }}</h6>
                                            <p class="text-primary fw-bold mb-2 fs-8">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
                                            <button wire:click="tambahProduk({{ $produk->id }})" class="btn btn-primary btn-sm w-100">
                                                Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if (isset($barang) && method_exists($barang, 'isEmpty') && $barang->isEmpty())
                            <div class="text-center py-4 text-muted">
                                <p class="fs-8">Produk tidak ditemukan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Keranjang --}}
            <div class="col-12 col-lg-4">
                <div class="card shadow">
                    <div class="card-body">
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-sm py-2 mb-2" role="alert">{{ session('error') }}</div>
                        @endif
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-sm py-2 mb-2" role="alert">{{ session('success') }}</div>
                        @endif

                        <h5 class="card-title mb-3">Keranjang</h5>

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fs-8">Produk</th>
                                        <th class="fs-8">Qty</th>
                                        <th class="fs-8">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($keranjang as $item)
                                        <tr>
                                            <td class="fs-8 text-truncate">{{ $item['nama'] }}</td>
                                            <td class="fs-8">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" wire:click="kurangiQty({{ $item['id'] }})" class="btn btn-outline-secondary">-</button>
                                                    <span class="btn btn-light" style="pointer-events: none;">{{ $item['qty'] }}</span>
                                                    <button type="button" wire:click="tambahQty({{ $item['id'] }})" class="btn btn-outline-secondary">+</button>
                                                </div>
                                            </td>
                                            <td class="fs-8 text-end">Rp{{ number_format($item['subtotal']) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-3 fs-8">
                                                Keranjang kosong
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-2">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fs-8">Total:</span>
                                <span class="fw-bold fs-8">Rp{{ number_format($total) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fs-8">Diskon:</span>
                                <span class="fw-bold fs-8">Rp{{ number_format($diskon) }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="tunai" class="form-label fs-8">Tunai:</label>
                            <input wire:model.live="tunai" type="number" class="form-control form-control-sm" id="tunai" required>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="fs-8">Kembalian:</span>
                                <span class="fw-bold text-success fs-8">Rp{{ number_format($kembalian) }}</span>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button wire:click="simpanTransaksi" class="btn btn-primary btn-sm" @disabled(!$tunai || empty($keranjang))>
                                Simpan Transaksi
                            </button>
                            <button wire:click="resetKeranjang" class="btn btn-outline-danger btn-sm">
                                Hapus Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
    
</div>