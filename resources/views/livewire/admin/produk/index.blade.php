<div>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Data Produk</h3>
                    <p class="text-subtitle text-muted">Kelola semua produk yang tersedia di toko</p>
                </div>

                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h4 class="card-title mb-0">Tabel Produk</h4>
                            <a href="{{ route('produk.form') }}" class="btn btn-primary btn-sm" wire:navigate>
                                <i class="bi bi-plus-lg me-1"></i> Tambah
                            </a>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <!-- Mobile Card View -->
                                <div class="d-md-none">
                                    @forelse($produk ?? [] as $item)
                                        <div class="card mb-3 border">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $item->nama }}</h6>
                                                <p class="mb-2">
                                                    <small class="text-muted">Kategori:</small><br>
                                                    <strong>{{ $item->kategori->nama ?? '-' }}</strong>
                                                </p>
                                                <p class="mb-2">
                                                    <small class="text-muted">Stok:</small><br>
                                                    <strong>{{ $item->stok }}</strong>
                                                </p>
                                                <p class="mb-2">
                                                    <small class="text-muted">Harga Beli:</small><br>
                                                    <strong>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</strong>
                                                </p>
                                                <p class="mb-3">
                                                    <small class="text-muted">Harga Jual:</small><br>
                                                    <strong>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</strong>
                                                </p>
                                                <div class="d-flex flex-wrap gap-2">
                                                    <button type="button" class="btn btn-info btn-sm text-white"
                                                        data-bs-toggle="modal" data-bs-target="#detail{{ $item->id }}">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </button>
                                                    <a href="{{ route('produk.form', $item->id) }}"
                                                        class="btn btn-warning btn-sm" wire:navigate>
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </a>
                                                    <button onclick="konfirmasiHapus({{ $item->id }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash2"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info">Tidak ada produk.</div>
                                    @endforelse
                                </div>

                                <!-- Desktop Table View -->
                                <div class="table-responsive d-none d-md-block">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Stok</th>
                                                <th>Harga Beli</th>
                                                <th>Harga Jual</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($produk ?? [] as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                                                    <td>{{ $item->stok }}</td>
                                                    <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                                    <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <button type="button" class="btn btn-info btn-sm text-white"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#detail{{ $item->id }}">
                                                                <i class="bi bi-eye"></i>
                                                            </button>
                                                            <a href="{{ route('produk.form', $item->id) }}"
                                                                class="btn btn-warning btn-sm" wire:navigate>
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <button onclick="konfirmasiHapus({{ $item->id }})"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="bi bi-trash2"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada produk.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Detail Produk -->
        @forelse($produk ?? [] as $item)
            <div class="modal fade" id="detail{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel{{ $item->id }}">Detail Produk: {{ $item->nama }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <dl class="row">
                                <dt class="col-sm-4">Nama:</dt>
                                <dd class="col-sm-8">{{ $item->nama }}</dd>

                                <dt class="col-sm-4">Kategori:</dt>
                                <dd class="col-sm-8">{{ $item->kategori->nama ?? '-' }}</dd>

                                <dt class="col-sm-4">Stok:</dt>
                                <dd class="col-sm-8">{{ $item->stok }}</dd>

                                <dt class="col-sm-4">Harga Beli:</dt>
                                <dd class="col-sm-8">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</dd>

                                <dt class="col-sm-4">Harga Jual:</dt>
                                <dd class="col-sm-8">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</dd>

                                <dt class="col-sm-4">Foto:</dt>
                                <dd class="col-sm-8">
                                    @if ($item->foto)
                                        <img src="{{ Storage::url($item->foto) }}" alt="Foto Produk" class="img-fluid rounded"
                                            style="max-width: 200px;">
                                    @else
                                        <span class="text-muted">Tidak ada foto</span>
                                    @endif
                                </dd>
                                @if ($item->barcode)
                                    <strong>Barcode:</strong><br>
                                    <img id="barcode-{{ $item->id }}"
                                        src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ $item->barcode }}"
                                        alt="Barcode" class="img-fluid w-50">
                                    <p>{{ $item->barcode }}</p>
                                    <button type="button" class="btn btn-primary mt-2"
                                        onclick="downloadBarcode({{ $item->id }}, '{{ $item->nama }}')" wire:ignore>
                                        Unduh Barcode
                                    </button>

                                    <script>
	function downloadBarcode(id, namaProduk) {
		const img = document.getElementById('barcode-' + id);
		if (!img) return alert("Barcode tidak ditemukan!");
		
		// Buat elemen canvas
		const canvas = document.createElement("canvas");
		const context = canvas.getContext("2d");
		
		// Tunggu gambar selesai di-load
		const barcodeImage = new Image();
		barcodeImage.crossOrigin = "anonymous";
		barcodeImage.src = img.src;
		
		barcodeImage.onload = function() {
			canvas.width = barcodeImage.width;
			canvas.height = barcodeImage.height;
			context.drawImage(barcodeImage, 0, 0);
			
			// Buat link download dengan nama produk
			const link = document.createElement("a");
			const sanitizedNamaProduk = namaProduk.replace(/[^a-zA-Z0-9]/g, '_'); // Sanitasi nama produk
			link.download = `barcode-${sanitizedNamaProduk}.png`;
			link.href = canvas.toDataURL("image/png");
			link.click();
		};
	}
</script>

                                @else
                                    <strong>Barcode:</strong>
                                    <p>Tidak ada barcode yang tersedia.</p>
                                @endif
                            </dl>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        @endforelse

    </div>